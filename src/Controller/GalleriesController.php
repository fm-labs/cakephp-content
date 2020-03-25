<?php
declare(strict_types=1);

namespace Content\Controller;

/**
 * Class GalleriesController
 *
 * @package Content\Controller
 */
class GalleriesController extends AppController
{
    /**
     * @param \Cake\Event\Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['view']);
    }

    /**
     * View method
     *
     * @param string|null $id Gallery id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     * @deprecated Use FlexsliderModuleCell instead.
     */
    public function view($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => ['Articles'],
            'media' => true,
        ]);
        $this->set('gallery', $gallery);
        $this->set('_serialize', ['gallery']);

        $view = $gallery->view_template ?: null;

        $this->render($view);
    }
}
