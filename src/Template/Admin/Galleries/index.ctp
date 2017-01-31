<?php $this->Breadcrumbs->add(__d('content','Galleries')); ?>
<?php $this->Toolbar->addLink(__d('content','New {0}', __d('content','Gallery')), ['action' => 'add'], ['data-icon' => 'plus']); ?>

<div class="galleries index">

    <!-- Galleries select -->
    <?= $this->Form->create(null, ['method' => 'GET']); ?>
    <div class="row">
        <div class="col-md-11">
            <?= $this->Form->input('id', ['label' => false, 'options' => $galleryTree, 'val' => (isset($gallery)) ? $gallery->id : null]); ?>
        </div>
        <div class="col-md-1">
            <?= $this->Form->button(__('Edit')); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>

    <!-- Data table -->
    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.Galleries',
        'data' => $galleries,
        'fields' => [
            'id',
            'parent' => [
                'formatter' => function($val) {
                    if ($val) {
                        return $this->Html->link($val->title, ['action' => 'manage', $val->id]);
                    }
                }
            ],
            'title' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'manage', $row->id]);
                }
            ],
            'view_template',
            'source'
        ],
        'rowActions' => [
            [__d('shop','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>
</div>
