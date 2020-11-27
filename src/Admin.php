<?php
declare(strict_types=1);

namespace Content;

use Admin\Core\BaseAdminPlugin;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Seo\Sitemap\Sitemap;
use Settings\SettingsManager;

/**
 * Class Plugin
 *
 * @package Content
 */
class Admin extends BaseAdminPlugin implements EventListenerInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);

        $routeClass = DashedRoute::class;
        $routes->connect('/{controller}', ['action' => 'index'], compact('routeClass'));
        $routes->connect('/{controller}/{action}/*', [], compact('routeClass'));
        $routes->connect('/{controller}/{action}', [], compact('routeClass'));
    }

    /**
     * @inheritDoc
     */
    public function implementedEvents(): array
    {
        return [
            'Admin.Menu.build.admin_primary' => ['callable' => 'buildAdminMenu', 'priority' => 5 ],
            'Admin.Menu.build.admin_system' => ['callable' => 'buildAdminSystemMenu', 'priority' => 5 ],
        ];
    }

    /**
     * @return array|array[]
     */
    protected function _getDesignMenuItems(): array
    {
        return [
            'page_layouts' => [
                'title' => 'Layouts',
                'url' => ['plugin' => 'Content', 'controller' => 'PageLayouts', 'action' => 'index'],
                'data-icon' => 'columns',
            ],
            'modules' => [
                'title' => 'Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'Modules', 'action' => 'index'],
                'data-icon' => 'puzzle-piece',
            ],
            'content_modules' => [
                'title' => 'Content Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'index'],
                'data-icon' => 'object-group',
            ],
        ];
    }

    /**
     * @return array|array[]
     */
    protected function _getMenuItems(): array
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
                'data-icon' => 'file-o',
            ],

            'posts' => [
                'title' => 'Posts',
                'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                'data-icon' => 'file-o',
            ],
            'menus' => [
                'title' => 'Menus',
                'url' => ['plugin' => 'Content', 'controller' => 'Menus', 'action' => 'index'],
                'data-icon' => 'sitemap',
            ],
            /*
            'galleries' => [
                'title' => 'Galleries',
                'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                'data-icon' => 'image',
            ],
            */

        ];
    }

    /**
     * @param \Cake\Event\Event $event
     * @param \Cupcake\Menu\MenuItemCollection $menu
     * @return void
     */
    public function buildAdminMenu(Event $event, \Cupcake\Menu\MenuItemCollection $menu): void
    {
        $menu->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => $this->_getMenuItems(),
        ]);
    }

    /**
     * @param \Cake\Event\Event $event
     * @param \Cupcake\Menu\MenuItemCollection $menu
     * @return void
     */
    public function buildAdminSystemMenu(Event $event, \Cupcake\Menu\MenuItemCollection $menu): void
    {
        $menu->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Info', 'action' => 'index'],
            'data-icon' => 'info',
            'children' => [],
        ]);
    }
}
