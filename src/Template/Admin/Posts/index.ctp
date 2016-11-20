<?php $this->Html->addCrumb(__d('content','Posts')); ?>
<?php $this->extend('/Admin/Content/index'); ?>
<?php
// EXTEND: TOOLBAR
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Post')), ['action' => 'add'], ['data-icon' => 'plus']);

// EXTEND: HEADING
$this->assign('heading', __d('content','Posts'));
?>
<div class="posts index">

    <!-- Quick Search -->
    <div class="ui segment">
        <div class="ui form">
            <?= $this->Form->create(null, ['id' => 'quickfinder', 'url' => ['action' => 'quick'], 'class' => 'no-ajax']); ?>
            <?= $this->Form->input('post_id', [
                'options' => $postsList,
                'label' => false,
                'empty' => '- Quick Search -'
            ]); ?>
            <?= $this->Form->button('Go'); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>


    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.Posts',
        'data' => $contents,
        'fields' => [
            'id',
            'created',
            'title' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'edit', $row->id]);
                }
            ],
            'is_published'
        ],
        'rowActions' => [
            [__d('shop','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>
</div>
