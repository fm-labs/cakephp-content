<?php

namespace Content\View\Module;

use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Banana\View\ViewModuleSchema;
use Banana\View\ViewModule;

/**
 * Class FlexsliderModule
 *
 * @package Content\View\Module
 */
class FlexsliderModule extends ViewModule
{
    public $modelClass = "Content.Galleries";

    public $gallery_id;

    public $template;

    protected $_validCellOptions = ['gallery_id', 'template'];

    protected function _buildSchema(ViewModuleSchema $schema)
    {
        $templates = function() {
            return ContentManager::getAvailableGalleryTemplates();
        };

        //$galleries = function() {
        //    return TableRegistry::get('Content.Galleries')->find('list');
        //};

        $schema
            ->addField('gallery_id',
                ['type' => 'select', 'empty' => true], ['model' => 'Content.Galleries' ])
            ->addField('template',
                ['type' => 'select', 'empty' => true], ['source' => $templates, ]);

        return $schema;

    }

    public function display($id = null)
    {
        $id = ($id) ?: $this->gallery_id;
        $template = $this->template;

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
}
