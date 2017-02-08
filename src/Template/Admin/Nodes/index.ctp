<?php $this->Breadcrumbs->add(__('Nodes')); ?>

<?php $this->Toolbar->addLink(__('New {0}', __('Node')), ['action' => 'add'], ['data-icon' => 'plus']); ?>
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
    __('List {0}', __('Parent Nodes')),
    ['controller' => 'Nodes', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Parent Node')),
    ['controller' => 'Nodes', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<div class="nodes index">

    <?php $fields = [
    'id','parent_id','title','type','typeid', 'url',
        'view_url' => ['formatter' => function($val) { return $this->Html->link($val); }],
        'hide_in_nav','hide_in_sitemap','created','modified',    ] ?>
    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.Nodes',
        'data' => $nodes,
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

