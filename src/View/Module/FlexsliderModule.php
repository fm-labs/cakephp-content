<?php
declare(strict_types=1);

namespace Content\View\Module;

use Cupcake\View\ViewModule;
use Cupcake\View\ViewModuleSchema;
use Cake\ORM\TableRegistry;
use Content\ContentManager;

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
        $templates = function () {
            return ContentManager::getAvailableGalleryTemplates();
        };

        //$galleries = function() {
        //    return TableRegistry::getTableLocator()->get('Content.Galleries')->find('list');
        //};

        $schema
            ->addField(
                'gallery_id',
                ['type' => 'select', 'empty' => true],
                ['model' => 'Content.Galleries' ]
            );
            //->addField('template',
            //    ['type' => 'select', 'empty' => true], ['source' => $templates, ])


        return $schema;
    }

    public function display($id = null)
    {
        $id = $id ?: $this->gallery_id;
        $template = $this->template;

        $gallery = TableRegistry::getTableLocator()->get('Content.Galleries')->get($id, [
            'contain' => ['Articles'],
            'media' => true,
        ]);
        $this->set('gallery', $gallery);

        $template = $template ?: $gallery->view_template;
        $this->viewBuilder()
            ->setClassName('Content.Content')
            ->setTemplate($template);
    }
}
