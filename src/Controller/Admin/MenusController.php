<?php
namespace Content\Controller\Admin;

use Cake\Routing\Router;
use Content\Controller\Admin\AppController;

/**
 * Menus Controller
 *
 * @property \Content\Model\Table\MenusTable $Menus
 * @deprecated Use NodesController instead
 */
class MenusController extends AppController
{

    public $modelClass = 'Content.Menus';

    public function manage($id = null) {

        $menu = null;
        $nodes = null;

        if ($id) {
            $menu = $this->Menus->get($id);
            $nodes = $this->Menus->Nodes->find()->where(['site_id' => $id])->order(['lft' => 'ASC'])->all();
        }
        $menus = $this->Menus->find()->all()->toArray();

        $newNode = $this->Menus->Nodes->newEntity();

        $this->set('menu', $menu);
        $this->set('menus', $menus);
        $this->set('nodes', $nodes);
        $this->set('newNode', $newNode);
        $this->set('nodeTypes', $this->Menus->Nodes->getTypeList());
    }

    public function treeData($menuId)
    {
        $this->viewBuilder()->className('Json');

        $tree = $this->Menus->toJsTree($menuId);
        $this->set('tree', $tree);
        $this->set('_serialize', 'tree');
    }

    public function treeSort()
    {

        $this->loadModel('Content.Nodes');

        $this->viewBuilder()->className('Json');
        $request = $this->request->data + ['nodeId' => null, 'oldParentId' => null, 'oldPos' => null, 'newParentId' => null, 'newPos' => null];

        $node = $this->Nodes->get($request['nodeId']);

        $this->Nodes->behaviors()->Tree->config('scope', ['site_id' => $node->site_id]);
        $this->Nodes->moveTo($node, $request['newParentId'], $request['newPos'], $request['oldPos']);

        $this->set('request', $request);
        $this->set('node',[
            'id' => $node->id,
            'site_id' => $node->site_id,
            'type' => $node->type,
            'typeid' => $node->typeid,
            'parent_id' => $node->parent_id,
            'level' => $node->level,
            'lft' => $node->lft,
            'url' => Router::url($node->getAdminUrl()),
        ]);
        $this->set('_serialize', ['request', 'message', 'node']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sites']
        ];
        $this->set('menus', $this->paginate($this->Menus));
        $this->set('_serialize', ['menus']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['Sites', 'Nodes', 'RootNodes']
        ]);
        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The {0} has been saved.', __('menu')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('menu')));
            }
        }
        $sites = $this->Menus->Sites->find('list', ['limit' => 200]);
        $this->set(compact('menu', 'sites'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The {0} has been saved.', __('menu')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('menu')));
            }
        }
        $sites = $this->Menus->Sites->find('list', ['limit' => 200]);
        $this->set(compact('menu', 'sites'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The {0} has been deleted.', __('menu')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('menu')));
        }
        return $this->redirect(['action' => 'index']);
    }
}
