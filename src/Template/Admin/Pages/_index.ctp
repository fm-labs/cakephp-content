<?php $this->Breadcrumbs->add(__d('content','Pages')); ?>
<?php
// TOOLBAR
//$this->Toolbar->addLink(__d('content','{0} (Tree)', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'sitemap']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'file-o']);
$this->Toolbar->addLink(__d('content','Sort'),
    ['plugin' => 'Backend',  'controller' => 'Tree', 'action' => 'index', 'model' => 'Content.Pages', 'op' => 'sort'],
    ['data-icon' => 'sitemap', 'data-modal' => true, 'data-modal-reload' => true]);
$this->Toolbar->addLink(__d('content','Repair Tree'), ['action' => 'repair'], ['data-icon' => 'wrench']);

// HEADING
//$this->assign('heading', __d('content','Pages'));

// CONTENT
?>
<div class="pages index">

    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'title' => false,
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
            'page_template',
            'is_published' => [
                'formatter' => function($val, $row) {
                    return $this->Ui->statusLabel($val);
                }
            ]
        ],
        'rowActions' => [
            [__d('content','View'), ['action' => 'view', ':id'], ['class' => 'view']],
            [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('content','Preview'), ['action' => 'preview', ':id'], ['class' => 'edit']],
            [__d('content','Copy'), ['action' => 'copy', ':id'], ['class' => 'copy']],
            [__d('content','Move Up'), ['action' => 'moveUp', ':id'], ['class' => 'move-up']],
            [__d('content','Move Down'), ['action' => 'moveDown', ':id'], ['class' => 'move-down']],
            [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>

</div>