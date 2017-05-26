<?php $this->Toolbar->addLink(__d('content','New {0}', __d('content','Page Layout')), ['action' => 'add'], ['data-icon' => 'plus']); ?>
<div class="pageLayouts index">


    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.PageLayouts',
        'data' => $pageLayouts,
        'fields' => [
            'id',
            'name' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'edit', $row->id]);
                }
            ],
            'template',
            'is_default'
        ],
        'rowActions' => [
            [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>
</div>
