<?php
declare(strict_types=1);

namespace Content\Controller;

/**
 * Class CategoriesController
 * @package Content\src\Controller
 * @property \Content\Model\Table\CategoriesTable $Categories
 * @property \Content\Model\Table\PagesTable $Pages
 */
class CategoriesController extends AppController
{
    /**
     * @var string
     */
    public $modelClass = "Content.Categories";

    /**
     * @param \Cake\Event\Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        if ($this->components()->has('Auth')) {
            $this->Authentication->allowUnauthenticated(['view']);
        }
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setClassName('Content.Category');
        $category = $this->Categories->get($id);

        if (!$this->request->is('requested')) {
            // force canonical url (except root pages)
            /*
            if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
                $here = Router::normalize($this->request->here);
                $canonical = Router::normalize($page->getViewUrl());

                if ($here != $canonical) {
                    $this->redirect($canonical, 301);
                    return;
                }
            }
            */

            $this->Frontend->setRefScope('Content.Categories');
            $this->Frontend->setRefId($id);
        }

        $this->loadModel('Content.Pages');
        $pages = $this->Pages->find('published')->where(['refscope' => 'Content.Categories', 'refid' => $id])->all()->toArray();

        $this->set(compact('category', 'posts'));
    }
}
