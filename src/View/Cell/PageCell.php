<?php
/**
 * Created by PhpStorm.
 * User: flow
 * Date: 5/24/15
 * Time: 5:27 PM
 */

namespace Content\View\Cell;

use Cake\View\Cell;
use Content\Model\Table\PagesTable;

/**
 * Class PageCell
 * @package App\View\Cell
 *
 * @property PagesTable $Pages
 */
class PageCell extends Cell
{
    public $modelClass = "Content.Pages";

    public function display($pageId = null)
    {
        $this->loadModel("Content.Pages");

        $page = $this->Pages->find()
            ->where(['Pages.id' => $pageId])
            ->contain(['ContentModules' => ['Modules']])
            ->first();

        $this->set('page', $page);
        $this->set('title', $page->title);
    }
}
