<?php $this->Html->addCrumb(__('Menu Items')); ?>

<?php $this->Toolbar->addLink(__('New {0}', __('Menu Item')), ['action' => 'add'], ['data-icon' => 'plus']); ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menus')),
    ['controller' => 'Menus', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu')),
    ['controller' => 'Menus', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Parent Menu Items')),
    ['controller' => 'MenuItems', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Parent Menu Item')),
    ['controller' => 'MenuItems', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<div class="menuItems index">

    <?php $fields = [
    'id','menu_id','lft','rght','level','parent_id','title','type','typeid','type_params','url','link_target','cssid','cssclass','hide_in_nav','hide_in_sitemap','created','modified',    ] ?>
    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.MenuItems',
        'data' => $menuItems,
        'fields' => $fields,
        'debug' => true,
        'rowActions' => [
            [__d('shop','View'), ['action' => 'view', ':id'], ['class' => 'view']],
            [__d('shop','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>

</div>

