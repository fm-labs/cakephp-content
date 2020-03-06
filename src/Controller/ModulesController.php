<?php
namespace Content\Controller;

use Cake\Event\Event;

/**
 * Class ModulesController
 *
 * @package Content\Controller
 */
class ModulesController extends ContentController
{
    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        if ($this->request->getQuery('iframe') === true) {
            $this->viewBuilder()->layout("Content.iframe/module");
        }

        $module = $this->Modules->get($id, [
            'contain' => []
        ]);
        $module = $this->Modules->modularize($module);
        $this->set('module', $module);
        $this->set('_serialize', ['module']);
    }
}
