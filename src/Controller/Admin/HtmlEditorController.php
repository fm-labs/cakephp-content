<?php
namespace Content\Controller\Admin;


use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Routing\Router;
use Media\Lib\Media\MediaManager;

class HtmlEditorController extends AppController
{
    public function imageList($media = 'images')
    {
        $this->viewBuilder()->className('Json');

        $list = [];
        try {
            $mm = MediaManager::get($media);
            $files = $mm->getSelectListRecursive();

            array_walk($files, function($filename, $idx) use (&$list, &$mm) {
                $list[] = [
                    'title' => $idx,
                    'value' => $filename
                ];
            });
        } catch (\Exception $ex) {
            Log::critical('HtmlEditor::imageList ' . $ex->getMessage(), ['content']);
        }
        $this->set('list', $list);
        $this->set('_serialize', 'list');
    }

    public function linkList()
    {
        $this->viewBuilder()->className('Json');

        $list = [];

        $this->eventManager()->on('Content.HtmlEditor.buildLinkList', function($event) {

            $_list = [];
            try {
                $this->loadModel('Content.Pages');
                $result = $this->Pages->find()->contain([])->all()->toArray();

                array_walk($result, function($entity) use (&$_list) {
                    $_list[] = [
                        'title' => str_repeat('_', $entity->level) . $entity->title,
                        //'value' => Router::url($entity->url, true)
                        'value' => sprintf('{{Content.Pages:%s}}', $entity->id)
                    ];
                });

            } catch (\Exception $ex) {
                Log::critical('HtmlEditor::linkList ' . $ex->getMessage(), ['content']);
            }

            $event->data['list'][] = ['title' => __d('content', 'Pages'), 'menu' => $_list];
        });

        $this->eventManager()->on('Content.HtmlEditor.buildLinkList', function($event) {

            $_list = [];
            try {
                $this->loadModel('Content.Posts');
                $result = $this->Pages->Posts
                    ->find()
                    ->where(['refscope' => 'Content.Pages'])
                    ->order(['title' => 'ASC'])
                    //->select(['id', 'title', 'level'])
                    ->contain([])
                    ->all()
                    ->toArray();

                array_walk($result, function($entity) use (&$_list) {
                    $_list[] = [
                        'title' => str_repeat('_', $entity->level) . $entity->title,
                        //'value' => Router::url($entity->url, true)
                        'value' => sprintf('{{Content.Posts:%s}}', $entity->id)
                    ];
                });

            } catch (\Exception $ex) {
                Log::critical('HtmlEditor::linkList ' . $ex->getMessage(), ['content']);
            }

            $event->data['list'][] = ['title' => __d('content', 'Posts'), 'menu' => $_list];
        });

        if (Plugin::loaded('Shop')):

            $this->eventManager()->on('Content.HtmlEditor.buildLinkList', function($event) {

                $_list = [];
                try {
                    $this->loadModel('Shop.ShopCategories');
                    $result = $this->ShopCategories->find()->contain([])->all()->toArray();

                    array_walk($result, function($entity) use (&$_list) {
                        $_list[] = [
                            'title' => str_repeat('_', $entity->level) . $entity->name,
                            //'value' => Router::url($entity->url, true)
                            'value' => sprintf('{{Shop.ShopCategories:%s}}', $entity->id)
                        ];
                    });

                } catch (\Exception $ex) {
                    Log::critical('HtmlEditor::linkList ' . $ex->getMessage(), ['content']);
                }

                $event->data['list'][] = ['title' => __d('content', 'Shop Categories'), 'menu' => $_list];
            });

        endif;

        $event = $this->dispatchEvent('Content.HtmlEditor.buildLinkList', ['list' => $list], $this);


        $this->set('list', $event->data['list']);
        $this->set('_serialize', 'list');
    }
}