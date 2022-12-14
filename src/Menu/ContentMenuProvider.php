<?php

namespace Content\Menu;

use Cake\ORM\TableRegistry;
use Cupcake\Menu\MenuItemCollection;
use Cupcake\Menu\MenuProviderInterface;

class ContentMenuProvider implements MenuProviderInterface
{
    /**
     * @var \Content\Model\Table\MenusTable
     */
    private $Menus;

    public function __construct(array $options = []) {
        debug($options);

        $this->Menus = TableRegistry::getTableLocator()->get('Content.Menus');
    }

    /**
     * @inheritDoc
     */
    public function getMenu(string $key): MenuItemCollection
    {
        // @todo get start node by key
        return $this->Menus->getMenu(1);
    }
}