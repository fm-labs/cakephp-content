<?php
declare(strict_types=1);

namespace Content\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Posts Controller
 *
 * @property \Content\Model\Table\PagesTable $Pages
 * @property \Content\Controller\Component\FrontendComponent $Frontend
 */
class PostsController extends AppController
{
    /**
     * @var string
     */
    public $modelClass = "Content.Pages";

    /**
     * @var string[]
     */
    public $allowedActions = ['index', 'view'];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $pages = $this->Pages->find()
            ->find('published')
            ->where(['Pages.type' => 'post'])
            ->orderDesc('id');

        $pages = $this->paginate($pages);

        $this->set('pages', $pages);
    }

    /**
     * @param null|int $id Page ID
     * @return \Cake\Http\Response|void
     * @throws \Exception
     */
    public function view($id = null)
    {
        if ($id === null) {
            switch (true) {
                case $this->request->getQuery('id'):
                    $id = $this->request->getQuery('id');
                    break;
                case $this->request->getParam('id'):
                    $id = $this->request->getParam('id');
                    break;
                case $this->request->getQuery('slug'):
                    $id = $this->Pages->findIdBySlug($this->request->getQuery('slug'));
                    break;
                case $this->request->getParam('slug'):
                    $id = $this->Pages->findIdBySlug($this->request->getParam('slug'));
                    break;
                default:
                    //throw new NotFoundException();
            }
        }

        try {
            /** @var \Content\Model\Entity\Page $page */
            $page = $this->Pages->get($id, [
                'media' => true,
                'attributes' => true,
            ]);

            if (!$page->isPublished()) {
                if ($this->Frontend->isPreviewMode()) {
                    $this->Flash->success("Preview mode");
                } else {
                    throw new NotFoundException();
                }
            }
        } catch (\Exception $ex) {
            //throw new NotFoundException();
            throw $ex;
        }

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

            $this->Frontend->setRefScope('Content.Pages');
            $this->Frontend->setRefId($id);
        }

        $this->set('page', $page);
        $this->set('_serialize', ['page']);

        //$template = ($page->template) ?: ((!$page->parent_id) ? $page->type . '_parent' : $page->type);
        $template = $page->template ?: $page->type;
        $template = $this->request->getQuery('template') ?: $template;
        $template = $template ?: null;

        $this->viewBuilder()
            ->setClassName('Content.Page')
            //->setTemplatePath(ucfirst(Inflector::camelize($this->getName())) . '/' . ucfirst(Inflector::camelize($page->type)))
            ->setTemplate($template);

        //$this->render($template);
    }
}
