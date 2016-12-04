<?php $this->Html->addCrumb(__('Menus')); ?>

<?php $this->Toolbar->addLink(__('New {0}', __('Menu')), ['action' => 'add'], ['data-icon' => 'plus']); ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Sites')),
    ['controller' => 'Sites', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Site')),
    ['controller' => 'Sites', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menu Items')),
    ['controller' => 'MenuItems', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu Item')),
    ['controller' => 'MenuItems', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<div class="menus index">

    <?= $this->cell('Backend.DataTable', [[
        'paginate' => false,
        'model' => 'Content.Menus',
        'data' => $menus,
        'fields' => [
            'site_id',
            'title' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'manage', $row->id]);
                }
            ]
        ],
        'debug' => false,
        'rowActions' => false
    ]]);
    ?>

</div>

