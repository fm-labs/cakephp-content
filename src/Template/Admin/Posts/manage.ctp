<?php
$this->loadHelper('Bootstrap.Panel');
$this->loadHelper('Bootstrap.Tabs');
//$this->extend('/Admin/Content/edit');

// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $post->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $post->id)]
);
$this->Toolbar->addLink(__d('content','Edit {0}', __d('content','Post')), ['action' => 'edit', $post->id], ['data-icon' => 'edit']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $post->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','List {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);


// HEADING
$this->assign('title', $post->title);

// CONTENT
?>
<div class="pages">

    <?php
    $this->Panel->create();
    $this->Panel->addAction(__d('content', 'Edit'),
        [ 'action' => 'edit', $post->id ],
        [ 'class' => 'link-edit btn btn-default btn-sm', 'data-icon' => 'edit']);
    /*
    $this->Panel->addAction(__d('content', 'Change Page Type'),
        [ 'action' => 'editPageType', $post->id ],
        [ 'class' => 'link-edit link-frame-modal btn btn-default btn-sm', 'data-icon' => 'edit']);
    */
    $this->Panel->addAction(__d('content', 'Preview'),
        [ 'action' => 'preview', $post->id ],
        [ 'class' => 'link-preview btn btn-default btn-sm', 'data-icon' => 'eye', 'target' => '_preview']);
    $this->Panel->addAction(__d('content', 'Delete'),
        [ 'action' => 'delete', $post->id ],
        [ 'class' => 'link-delete btn btn-danger btn-sm',
            'data-icon' => 'trash-o',
            'confirm' => __d('content', 'Sure ?'),
        ]);
    ?>
    <?php $this->Panel->heading(); ?>
        <i class="fa fa-file-o"></i>
        <strong><?= __d('content', 'Post'); ?></strong>
        <?= h($post->title); ?>

    <?php $this->Panel->body(); ?>
    <?= $this->cell('Backend.EntityView', [ $post ], [
            'title' => false,
            'model' => 'Content.Posts',
            'fields' => [
                'title' => [
                    'formatter' => function($val, $entity) {
                        return $this->Html->link($val, ['action' => 'edit', $entity->id]);
                    }
                ],
                'type' => [
                    'formatter' => function($val) {
                        $html = h($val);
                        $html .= "&nbsp;";
                        $html .= $this->Html->link(__('Change type'), ['action' => 'editPageType']);
                        return $html;
                    }
                ],
                'is_published' => ['formatter' => 'boolean'],
                'url' => [
                    'formatter' => function($val) {
                        return $this->Html->link($this->Html->Url->build($val), $val, ['target' => '_blank']);
                    }
                ]
            ],
            'exclude' => '*'
        ]); ?>
    <?= $this->Panel->render(); ?>

    <?php
    $typeElement = 'Content.Admin/Posts/manage_' . $post->type;
    if ($this->elementExists($typeElement)) {
        echo $this->element($typeElement, ['post' => $post]);
    } else {
        echo "Post type element not found: $typeElement";
    }
    ?>

    <?= $this->Panel->create(); ?>

        <?php $this->Tabs->start(); ?>
        <?php

        $this->Tabs->add(__d('content', 'Details'));
        ?>
    <?= $this->cell('Backend.EntityView', [ $post ], [
        'title' => false,
        'model' => 'Content.Posts',
    ]); ?>
    <?php

        $this->Tabs->add(__d('content', 'Meta'));
    ?>
    <?= $this->cell('Backend.EntityView', [ $post ], [
        'title' => false,
        'model' => 'Content.Posts',
        'fields' => [
            'meta_title',
            'meta_desc',
            'meta_robots',
            'meta_lang'
        ],
        'exclude' => '*'
    ]); ?>
    <?php

        $this->Tabs->add(__d('content', 'Content Modules'), [
            'url' => $this->Html->Url->build([
                'controller' => 'ContentModules',
                'action' => 'related',
                'Content.Posts', $post->id
            ])
        ]);
        echo $this->Tabs->render();
        ?>

</div>
