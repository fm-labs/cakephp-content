<?php
namespace Content\Controller;

use Cake\Event\Event;

/**
 * Class GalleriesController
 *
 * @package Content\Controller
 */
class GalleriesController extends ContentController
{
    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
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
            'contain' => ['Posts'],
            'media' => true,
        ]);
        $this->set('gallery', $gallery);
        $this->set('_serialize', ['gallery']);

        $view = ($gallery->view_template) ?: null;

        $this->render($view);
    }
}
