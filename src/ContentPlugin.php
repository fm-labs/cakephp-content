<?php

namespace Content;

use Backend\Event\RouteBuilderEvent;
use Backend\View\BackendView;
use Banana\Menu\Menu;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Content\Lib\ContentManager;
use Settings\SettingsManager;

class ContentPlugin implements EventListenerInterface
{

    /**
     * @param EventManager $eventManager
     * @return $this
     */
    public function registerEvents(EventManager $eventManager)
    {
    }

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * @see EventListenerInterface::implementedEvents()
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents()
    {
        return [
            //'Content.Model.PageTypes.get' => 'getContentPageTypes', //@deprecated
            'Settings.build' => 'buildSettings',
            'Backend.Menu.build' => ['callable' => 'buildBackendMenu', 'priority' => 5 ],
            'Backend.Sidebar.build' => ['callable' => 'buildBackendMenu', 'priority' => 5 ],
            //'Backend.SysMenu.build' => ['callable' => 'buildBackendSidebarMenu', 'priority' => 50 ],
            'Backend.Routes.build' => 'buildBackendRoutes',
            'View.beforeLayout' => ['callable' => 'beforeLayout']
        ];
    }

    public function getContentPageTypes(Event $event)
    {
        $event->result['content'] = [
            'title' => 'Content Page',
            'className' => 'Content.Content'
        ];
        $event->result['static'] = [
            'title' => 'Static Page',
            'className' => 'Content.Static'
        ];
        $event->result['controller'] = [
            'title' => 'Controller',
            'className' => 'Content.Controller'
        ];
        $event->result['redirect'] = [
            'title' => 'Redirect',
            'className' => 'Content.Redirect'
        ];
        $event->result['root'] = [
            'title' => 'Root Page',
            'className' => 'Content.Root'
        ];
    }

    public function beforeLayout(Event $event)
    {
        if ($event->subject() instanceof BackendView && $event->subject()->plugin == "Content") {
            //$menu = new Menu($this->_getMenuItems());
            //$menu->addItems($this->_getDesignMenuItems());
            //$event->subject()->set('backend.sidebar.menu', $menu);
        }
    }

    protected function _getDesignMenuItems()
    {
        return [
            'page_layouts' => [
                'title' => 'Layouts',
                'url' => ['plugin' => 'Content', 'controller' => 'PageLayouts', 'action' => 'index'],
                'data-icon' => 'columns'
            ],
            'modules' => [
                'title' => 'Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'Modules', 'action' => 'index'],
                'data-icon' => 'puzzle-piece'
            ],
            'content_modules' => [
                'title' => 'Content Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'index'],
                'data-icon' => 'object-group'
            ]
        ];
    }

    protected function _getMenuItems()
    {
        return [

            /*
            'categories' => [
                'title' => 'Categories',
                'url' => ['plugin' => 'Content', 'controller' => 'Categories', 'action' => 'index'],
                'data-icon' => 'folder-o',
            ],
            */

            'pages' => [
                'title' => 'Pages',
                'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                'data-icon' => 'sitemap',
            ],

            'posts' => [
                'title' => 'Posts',
                'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                'data-icon' => 'file-o',
            ],

            'galleries' => [
                'title' => 'Galleries',
                'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                'data-icon' => 'image'
            ],

        ];
    }


    /**
     * @param Event $event
     */
    public function buildSettings(Event $event)
    {
        if ($event->subject() instanceof SettingsManager) {
            $event->subject()->add('Content', [
                'Router.enablePrettyUrls' => [
                    'type' => 'boolean',
                ],
                'Router.forceCanonical' => [
                    'type' => 'boolean',
                ],
            ]);
        }
    }

    public function buildBackendRoutes(RouteBuilderEvent $event)
    {
        $event->subject()->scope('/content',
            ['plugin' => 'Content', '_namePrefix' => 'content:admin:', 'prefix' => 'admin'],
            function(RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
                $routes->fallbacks('DashedRoute');
            });
    }

    public function buildBackendMenu(Event $event)
    {
        $event->subject()->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => $this->_getMenuItems()
        ]);
    }

    public function buildBackendSidebarMenu(Event $event)
    {
//        $event->subject()->addItem([
//            'title' => 'Design',
//            'url' => ['plugin' => 'Content', 'controller' => 'Themes', 'action' => 'index'],
//            'data-icon' => 'paint-brush',
//            'children' => [
//            ],
//        ]);
    }

    /**
     * @param EventManager $eventManager
     */
    public function __invoke(EventManager $eventManager)
    {
        //@todo Let the application know that we support sitemaps via the Sitemap plugin
        $eventManager->on(new \Content\Sitemap\SitemapListener());

        //new ContentManager();
    }
}
