<?php
// Breadcrumbs
$this->Breadcrumbs->add(__d('content','Pages'));

// Toolbar
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);

// Vars
$this->assign('title', __d('content','Pages'));
?>
<div class="posts index">

    <!-- Quick Search
    <?= $this->Form->create(null, ['id' => 'quickfinder', 'url' => ['action' => 'quick'], 'class' => 'no-ajax']); ?>
    <?= $this->Form->input('post_id', [
        'options' => $postsList,
        'label' => false,
        'empty' => '- Quick Search -'
    ]); ?>
    <?= $this->Form->button('Go'); ?>
    <?= $this->Form->end() ?>
     -->

    <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <?= $this->Form->create(null, ['method' => 'GET', 'horizontal' => true]); ?>
            <?= $this->Form->input('q', [
                'type' => 'datalist',
                'options' => $postsList->toArray(),
                'value' => $this->request->query('q'),
                'placeholder' => 'Enter search word',
                'label' => 'Search',
            ]); ?>
            <!--
            <div class="pull-right">
                <?= $this->Form->button('search'); ?>
            </div>
            -->
            <?= $this->Form->end(); ?>
        </div>
    </div>


    <?php $this->loadHelper('Backend.DataTableJs'); ?>
    <?= '' //$this->DataTableJs->create('Content.Posts')->render(); ?>


    <?= $this->cell('Backend.DataTable', [[
        'paginate' => true,
        'model' => 'Content.Posts',
        'data' => $posts,
        'fields' => [
            'id',
            'created',
            //'type',
            //'parent',
            'title' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'edit', $row->id]);
                }
            ],
            'is_published' => [
                'formatter' => function($val, $row) {
                    return $this->Ui->statusLabel($val, ['map' => [['Unpublished','danger'], ['Published','success']]]);
                }
            ]
        ],
        'rowActions' => [
            [__d('shop','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>
</div>
