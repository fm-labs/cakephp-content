<?php

namespace Content\Controller;


use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * Class FrontendController
 *
 * @package Content\Controller
 */
class FrontendController extends AppController
{
    public $modelClass = false;

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->loadComponent('Banana.Site');
        $this->loadComponent('Content.Frontend');

        if ($this->components()->has('Auth')) {
            $this->Auth->allow(['index']);
        }
    }

    /**
     * Index method
     */
    public function index()
    {
        // Find root page
        $siteId = $this->Site->getSiteId();

        $this->loadModel('Content.Nodes');
        $rootNode = $this->Nodes->find()->where(['parent_id IS' => null, 'site_id' => $siteId])->first();

        //@TODO Replace with soft 404
        if (!$rootNode) {
            throw new NotFoundException('Sorry, nothing');
        }

        // Find first entry
        $firstChild = $this->Nodes->find('children', ['for' => $rootNode->id])->first();
        //@TODO Replace with soft 404
        if (!$firstChild) {
            throw new NotFoundException('Sorry, no contents found');
        }

        //$this->response->statusCode(404);
        debug($firstChild);
        debug($rootNode);

        $url = $firstChild->getViewUrl();
        //@TODO Replace with soft 404
        if (!$url) {
            throw new NotFoundException('Sorry, no contents found');
        }
        $this->redirect($url);
    }
}