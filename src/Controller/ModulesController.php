<?php
namespace Content\Controller;


use Cake\Event\Event;

class ModulesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow();
    }

    public function view($id = null)
    {
        if ($this->request->query('iframe') === true) {
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