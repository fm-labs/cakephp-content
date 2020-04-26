<?php
declare(strict_types=1);

namespace Content\View;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest as Request;
use Cake\View\View;
use Content\Model\Entity\ContentModule;

/**
 * Class FrontendView
 *
 * @package App\View
 *
 * @property \Content\View\Helper\BreadcrumbsHelper $Breadcrumbs
 */
class ContentView extends View
{
    /**
     * {@inheritDoc}
     */
    public function __construct(
        ?Request $request = null,
        ?Response $response = null,
        ?EventManager $eventManager = null,
        array $viewOptions = []
    ) {
        parent::__construct($request, $response, $eventManager, $viewOptions);
    }

    /**
     * {@inheritDoc}
     */
    public function initialize(): void
    {
        $this->loadHelper('Content.Breadcrumbs');
        $this->loadHelper('Content.Content');
        $this->loadHelper('Content.Meta');
        $this->loadHelper('Content.Shortcode');

        // collect additional helpers
        $event = new Event('Content.View.initialize', $this);
        $this->getEventManager()->dispatch($event);
    }

    /**
     * Render a section.
     *
     * @param string $section Section name
     * @param array $options Section options
     * @return string|null
     */
    public function section(string $section, array $options = [])
    {
        // skip section rendering when '_bare' view flag is set
        if ($this->get('_bare')) {
            return null;
        }

        $content = $this->fetch($section);
        if ($content) {
            return $content;
        }

        $options = array_merge(['wrap' => 'section'], $options);
        $refscope = $this->get('refscope');
        $refid = $this->get('refid');

        $pageModules = $this->_loadPageModules($section, $refscope, $refid);
        if (count($pageModules) < 1) {
            $pageModules = $this->_loadLayoutModules($section, $refscope, $refid);
        }

        $sectionHtml = "";
        foreach ($pageModules as $contentModule) :
            $sectionHtml .= $this->contentModule($contentModule);
        endforeach;

        if ($options['wrap'] && $sectionHtml) {
            $sectionAttrs = $options;
            $sectionAttrs['data-section'] = $section;
            $sectionAttrs['data-section-refscope'] = $refscope;
            $sectionAttrs['data-section-refid'] = $refid;
            unset($sectionAttrs['wrap']);

            $sectionHtml = $this->Html->tag($options['wrap'], $sectionHtml, $sectionAttrs);
        }

        return $sectionHtml;
    }

    /**
     * @deprecated
     */
    protected function _loadPageModules($section = null, $refscope = null, $refid = null)
    {
        return [];

        // To Optimize performance -> Do not request modules for every section. Cache for refscope instead
        //return TableRegistry::getTableLocator()->get('Content.ContentModules')->find()
        //    ->where(['section' => $section, 'refscope' => $refscope, 'refid' => $refid])
        //    ->contain(['Modules'])
        //    ->all();
    }

    /**
     * @deprecated
     */
    protected function _loadLayoutModules($section = null, $refscope = null, $refid = null)
    {
        return [];

        // To Optimize performance -> Do not request modules for every section. Cache for refscope instead
        //return TableRegistry::getTableLocator()->get('Content.ContentModules')->find()
        //    ->where(['section' => $section, 'refid IS NULL', 'or' => ['refscope' => $refscope, 'refscope IS NULL']])
        //    ->contain(['Modules'])
        //    ->all();
    }

    /*
    public function module(Module $module, $cellData = [], $template = null)
    {
        $cell = $module->cellClass;

        try {
            $template = ($template) ?: null;
            $moduleHtml = $this->cell($cell , $cellData, compact('module'))->render($template);
        } catch (\Exception $ex) {
            $moduleHtml = sprintf('Unable to render content module %s [%s]: %s', $module->name, $module->path, $ex->getMessage());
        }

        return $moduleHtml;
    }
    */

    /**
     * @param \Content\Model\Entity\ContentModule $contentModule Content module instance
     * @param array $moduleData Module data
     * @param array $wrapperAttrs Wrapper attributes
     * @return \Banana\View\ViewModule|string|null
     */
    public function contentModule(ContentModule $contentModule, array $moduleData = [], array $wrapperAttrs = [])
    {
        if (!$contentModule->module) {
            if (Configure::read('debug')) {
                return "Content Module with ID " . $contentModule->id . " has no module attached";
            }

            return null;
        }

        $moduleHtml = $this->module(
            $contentModule->module->cellClass,
            $moduleData,
            $contentModule->module->params_arr
        );

        // output module without wrapper container, if css class is set to '_nowrap'
        // @todo Create virtual property 'nowrap' in ContentModule entity (and
        if ($contentModule->nowrap || $contentModule->cssclass === '_nowrap') {
            return $moduleHtml;
        }

        $wrapperAttrs = array_merge([
            'id' => $contentModule->cssid,
            'class' => $contentModule->cssclass,
            'data-content-module-id' => $contentModule->id,
        ], $wrapperAttrs);

        return $this->Html->div(null, (string)$moduleHtml, $wrapperAttrs);
    }

    public function module($moduleName, $data, array $options = [])
    {
        return sprintf("[ %s:%s ] ", $moduleName, json_encode($options));
    }

    /**
     * {@inheritDoc}
     */
    public function fetch(string $name, string $default = ''): string
    {
        $content = parent::fetch($name);

        if ($this->getCurrentType() == 'layout') {
            if ($name !== 'content'/* && !$content */) {
                $elementPath = 'layout/' . $this->layout . '/' . $name;
                if ($this->elementExists($elementPath)) {
                    $content .= $this->element($elementPath);
                }
            }
        }

        // render short codes
        //$content = $this->renderShortCodes($content);

        return $content ?: $default;
    }

    /**
     * {@inheritDoc}
     */
    public function render(?string $template = null, $layout = null): string
    {
        if (Configure::read('debug')) {
            $this->set('__debugInfo', $this->__debugInfo());
        }

        return parent::render($template, $layout);
    }

    /**
     * Debug Info
     * @return array
     */
    public function __debugInfo(): array
    {
        return [
            'type' => $this->getCurrentType(),
            'theme' => $this->getTheme(),
            'layout' => $this->getLayout(),
            'template' => $this->getTemplate(),
            'templatePath' => $this->getTemplatePath(),
            'layoutPath' => $this->getLayoutPath(),
            'subDir' => $this->getSubDir(),
        ];
    }
}
