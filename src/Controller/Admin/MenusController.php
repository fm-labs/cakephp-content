<?php
declare(strict_types=1);

namespace Content\Controller\Admin;

/**
 * @property \Content\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{
    public $modelClass = "Content.Menus";

    public $actions = [
        'add' => 'Backend.Add',
        'sort' => 'Backend.TreeSort',
    ];

    /**
     * @return void
     */
    public function index()
    {
        $menuTreeList = $this->Menus->find('treeList');
        $menusThreaded = $this->Menus->find()
            ->find('threaded')
            ->orderAsc('lft')
            ->all();
        $this->set(compact('menuTreeList', 'menusThreaded'));

        $menuItem = null;

        $menuId = $this->request->getQuery('menu_id');
        if ($menuId) {
            $menu = $this->Menus->getMenu($menuId);
            //$menu = \Content\ContentManager::getMenuById(8);
            //debug($menu);
            $this->set(compact('menu'));
        }

        if ($this->request->getQuery('menu_item_id')) {
            $menuItemId = $this->request->getQuery('menu_item_id');
            $menuItem = $this->Menus->get($menuItemId);

            if ($this->request->is(['put', 'post'])) {
                //debug($this->request->getData());

                $data = $this->request->getData();
                $menuItem = $this->Menus->patchEntity($menuItem, $data);

                if ($this->Menus->save($menuItem)) {
                    $this->Flash->success("Saved");
                    //$this->redirect($this->request->url);
                    $this->redirect(['action' => 'index', 'menu_item_id' => $menuItem->id]);
                } else {
                    $this->Flash->error("Something went wrong");
                    debug($menuItem->getErrors());
                }
            }

            $this->set(compact('menuItem'));
        } elseif ($this->request->getQuery('add')) {
            $menuItem = $this->Menus->newEmptyEntity();

            if ($this->request->is(['put', 'post'])) {
                //debug($this->request->getData());

                $data = $this->request->getData();
                $menuItem = $this->Menus->patchEntity($menuItem, $data);

                if ($this->Menus->save($menuItem)) {
                    $this->Flash->success("Added");
                    $this->redirect(['action' => 'index', 'menu_item_id' => $menuItem->id]);
                } else {
                    $this->Flash->error("Something went wrong");
                    debug($menuItem->getErrors());
                }
            }
        }

        $menuTypes = $this->Menus->getTypeList();
        $this->set(compact('menuItem', 'menuTypes'));

        // ----------

        $menuRoots = $this->Menus->find()
            ->where(['parent_id IS NULL'])
            ->all();

        $this->set('menuRoots', $menuRoots);
    }
}
