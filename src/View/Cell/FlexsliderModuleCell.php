<?php

namespace Content\View\Cell;

use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Event\EventDispatcherInterface;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Banana\View\ViewModule;

/**
 * Class FlexsliderModuleCell
 *
 * @package Content\View\Cell
 */
class FlexsliderModuleCell extends ViewModule // ModuleCell //implements EventDispatcherInterface
{
    public $modelClass = "Content.Galleries";

    public static $defaultParams = [
        'gallery_id' => null,
        'template' => null,
    ];


    public static function inputs()
    {
        $galleries = TableRegistry::get('Content.Galleries')->find('list');
        $templates = ContentManager::getAvailableGalleryTemplates();

        return [
            'gallery_id' => ['type' => 'select', 'options' => $galleries, 'empty' => true],
            'template' => ['type' => 'select', 'options' => $templates, 'empty' => true]
        ];
    }

    public function display($id = null)
    {
        $id = ($id) ?: $this->params['gallery_id'];
        $template = $this->params['template'];

        $gallery = TableRegistry::get('Content.Galleries')->get($id, [
            'contain' => ['Posts'],
            'media' => true,
        ]);
        $this->set('gallery', $gallery);

        $template = $template ?: $gallery->view_template;
        $this->viewBuilder()
            ->className('Content.Content')
            ->template($template);
    }

    public function implementedEvents()
    {
        return [
            'View.beforeRender' => 'beforeRender',
            'View.beforeLayout' => 'beforeLayout'
        ];
    }

    public function beforeRender(Event $event)
    {
        Log::debug('FlexsliderModuleCell:View.beforeRender' . get_class($event->subject()));
    }

    public function beforeLayout(Event $event)
    {
        Log::debug('FlexsliderModuleCell:View.beforeLayout');
    }
}
