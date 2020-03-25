<div class="modules index">


    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.Modules',
        'data' => $modules,
        'fields' => [
            'id',
            'name' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'view', $row->id]);
                }
            ],
            'title',
            'path'
        ],
        'rowActions' => [
            [__d('content','View'), ['action' => 'view', ':id'], ['class' => 'view']],
            [__d('content','Edit'), ['controller' => 'ModuleBuilder', 'action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>
</div>
