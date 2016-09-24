<?php
/**
 * Created by PhpStorm.
 * User: flow
 * Date: 5/24/15
 * Time: 5:27 PM
 */

namespace Content\View\Cell;

use Cake\Database\Schema\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Table\PagesTable;


class FlexsliderModuleCell extends ModuleCell
{
    public $modelClass = "Content.Pages";

    public static $defaultParams = [
        'gallery_id' => null,
    ];


    public static function inputs()
    {
        $galleries = TableRegistry::get('Content.Galleries')->find('list');

        return [
            'gallery_id' => ['type' => 'select', 'options' => $galleries]
        ];
    }
}
