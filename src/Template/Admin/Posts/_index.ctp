<?php
// Breadcrumbs
$this->Breadcrumbs->add(__d('content','Posts'));

// Toolbar
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Post')), ['action' => 'add'], ['data-icon' => 'plus']);

// Vars
$this->assign('title', __d('content','Posts'));
?>
<div class="posts index">

    <!-- Quick Search
    <?= $this->Form->create(null, ['id' => 'quickfinder', 'url' => ['action' => 'quick'], 'class' => 'no-ajax']); ?>
    <?= $this->Form->control('post_id', [
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
            <?= $this->Form->control('q', [
                'type' => 'datalist',
                'options' => $postsList->toArray(),
                'value' => $this->request->getQuery('q'),
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
            'type',
            'parent',
            'title' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['action' => 'edit', $row->id]);
                }
            ],
            'is_published'
        ],
        'rowActions' => [
            [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
            [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>
</div>
