<?php
namespace Content\Controller;

use Cake\Event\Event;
use Content\Model\Table\CategoriesTable;
use Content\Model\Table\PostsTable;

/**
 * Class CategoriesController
 * @package Content\src\Controller
 * @property CategoriesTable $Categories
 * @property PostsTable $Posts
 */
class CategoriesController extends ContentController
{
    /**
     * @var string
     */
    public $modelClass = "Content.Categories";

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if ($this->components()->has('Auth')) {
            $this->Auth->allow(['view']);
        }
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $this->viewBuilder()->className('Content.Category');
        $category = $this->Categories->get($id);

        if (!$this->request->is('requested')) {
            // force canonical url (except root pages)
            /*
            if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
                $here = Router::normalize($this->request->here);
                $canonical = Router::normalize($post->getViewUrl());

                if ($here != $canonical) {
                    $this->redirect($canonical, 301);
                    return;
                }
            }
            */

            $this->Frontend->setRefScope('Content.Categories');
            $this->Frontend->setRefId($id);
        }

        $this->loadModel('Content.Posts');
        $posts = $this->Posts->find('published')->where(['refscope' => 'Content.Categories', 'refid' => $id])->all()->toArray();

        $this->set(compact('category', 'posts'));
    }
}
