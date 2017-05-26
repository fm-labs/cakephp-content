<?php $this->Breadcrumbs->add(__d('content', 'Categories')); ?>
<?php $this->loadHelper('Backend.Toolbar'); ?>
<?php $this->Toolbar->addLink(__d('content', 'New {0}', __d('content', 'Category')), ['action' => 'add'], ['data-icon' => 'plus']); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Posts')),
    ['controller' => 'Posts', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __d('content', 'New {0}', __d('content', 'Post')),
    ['controller' => 'Posts', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<div class="categories index">

    <?php $fields = [
    'id','name','slug','is_published',    ] ?>
    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.Categories',
        'data' => $categories,
        'fields' => $fields,
        'debug' => true,
        'rowActions' => [
            [__d('content','View'), ['action' => 'view', ':id'], ['class' => 'view']],
            [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>

</div>

