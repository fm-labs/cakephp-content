<?php
namespace Content\View;

use Banana\View\ViewModuleTrait;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;
use Cake\View\View;
use Content\Model\Entity\ContentModule;
use Content\View\Helper\BreadcrumbsHelper;

/**
 * Class FrontendView
 *
 * @package App\View
 *
 * @property BreadcrumbsHelper $Breadcrumbs
 */
class ContentView extends View
{
    use ViewModuleTrait;

    /**
     * @param Request $request
     * @param Response $response
     * @param EventManager $eventManager
     * @param array $viewOptions
     */
    public function __construct(
        Request $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $viewOptions = []
    ) {
        parent::__construct($request, $response, $eventManager, $viewOptions);

    }

    public function initialize()
    {
        $this->loadHelper('Content.Breadcrumbs');
        $this->loadHelper('Content.Content');
        $this->loadHelper('Form', [
            'className' => 'Bootstrap\View\Helper\FormHelper',
        ]);

        // collect additional helpers
        $event = new Event('Content.View.Helper.get', $this);
        $this->eventManager()->dispatch($event);
    }

    public function section($section, array $options = [])
    {
        $content = $this->fetch($section);
        if ($content) {
            return $content;
        }

        $options = array_merge(['wrap' => 'section'], $options);
        $refscope = $this->get('refscope');
        $refid = $this->get('refid');

        $page_modules = $this->_loadPageModules($section, $refscope, $refid);
        if (count($page_modules) < 1) {
            $page_modules = $this->_loadLayoutModules($section, $refscope, $refid);
        }

        $sectionHtml = "";
        foreach ($page_modules as $contentModule):
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

    protected function _loadPageModules($section = null, $refscope = null, $refid = null)
    {
        // @TODO Optimize performance -> Do not request modules for every section. Cache for refscope instead
        return TableRegistry::get('Content.ContentModules')->find()
            ->where(['section' => $section, 'refscope' => $refscope, 'refid' => $refid])
            ->contain(['Modules'])
            ->all();
    }

    protected function _loadLayoutModules($section = null, $refscope = null, $refid = null)
    {
        // @TODO Optimize performance -> Do not request modules for every section. Cache for refscope instead
        return TableRegistry::get('Content.ContentModules')->find()
            ->where(['section' => $section, 'refid IS NULL', 'or' => ['refscope' => $refscope, 'refscope IS NULL']])
            ->contain(['Modules'])
            ->all();
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
            'data-content-module-id' => $contentModule->id
        ], $wrapperAttrs);
        return $this->Html->div(null, $moduleHtml, $wrapperAttrs);
    }

    public function render($view = null, $layout = null)
    {
        return parent::render($view, $layout);
    }

}
