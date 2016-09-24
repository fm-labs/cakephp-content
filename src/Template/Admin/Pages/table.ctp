<?php $this->Html->addCrumb(__d('content','Pages')); ?>
<?php $this->extend('/Admin/Content/index'); ?>
<?php
// TOOLBAR
$this->Toolbar->addLink(__d('content','{0} (Tree)', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'sitemap']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'file-o', 'class' => 'link-frame-modal']);
$this->Toolbar->addLink(__d('content','Repair Tree'), ['action' => 'repair'], ['data-icon' => 'wrench']);

// HEADING
$this->assign('heading', __d('content','Pages'));

// CONTENT
?>
<div class="pages index">

    <!-- Quick Search -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Quick Search
        </div>
        <div class="panel-body">
            <?= $this->Form->create(null, ['id' => 'quickfinder', 'action' => 'quick', 'class' => 'no-ajax']); ?>
            <?= $this->Form->input('page_id', [
                'options' => $pagesTree,
                'label' => false,
                'empty' => '- Quick Search -'
            ]); ?>
            <?= $this->Form->button('Go'); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="actions right grouped">
        <ul>
            <!--
            <li><?= $this->Html->link(
                    __d('content', 'Reorder (tree)'),
                    [
                        'controller' => 'Sort', 'action' => 'reorder', 'model' => 'Content.Pages',
                        'field' => 'lft',  'order' => 'asc',
                        'scope' => []
                    ],
                    ['class' => 'link-frame btn btn-default']); ?></li>
            -->
        </ul>
    </div>
    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        //'sortable' => true,
        //'sortUrl' => ['plugin' => 'Content', 'controller' => 'Sort', 'action' => 'tableSort'],
        'model' => 'Content.Pages',
        'data' => $contents,
        'fields' => [
            'id',
            'title' => [
                'formatter' => function($val, $row) use ($pagesTree) {
                    return $this->Html->link($pagesTree[$row->id], ['action' => 'edit', $row->id]);
                }
            ],
            'type',
            'is_published' => [
                'formatter' => function($val, $row) {
                    return $this->Ui->statusLabel($val);
                }
            ]
        ],
        'rowActions' => [
            [__d('shop','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('shop','Preview'), ['action' => 'preview', ':id'], ['class' => 'edit']],
            [__d('shop','Copy'), ['action' => 'copy', ':id'], ['class' => 'copy']],
            [__d('shop','Move Up'), ['action' => 'moveUp', ':id'], ['class' => 'move-up']],
            [__d('shop','Move Down'), ['action' => 'moveDown', ':id'], ['class' => 'move-down']],
            [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>

</div>