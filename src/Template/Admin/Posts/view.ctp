<?php
$this->loadHelper('Bootstrap.Tabs');

// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $post->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $post->id)]
);
$this->Toolbar->addLink(__d('content','Edit'), ['action' => 'edit', $post->id], ['data-icon' => 'edit']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $post->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','List {0}', __d('content','Posts')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Post')), ['action' => 'add'], ['data-icon' => 'plus']);


// HEADING
$this->assign('title', $post->title);

// CONTENT
?>
<div class="view">

    <?php $this->Tabs->start(); ?>
    <!-- Details -->
    <?php $this->Tabs->add(__d('content', 'Details'));
    ?>
    <?= $this->cell('Backend.EntityView', [ $post ], [
        'title' => false,
        'model' => 'Content.Posts'
    ]); ?>

    <!-- Meta -->
    <?php $this->Tabs->add(__d('content', 'Meta')); ?>
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

    <!-- Content Modules -->
    <?php
    /*
    $this->Tabs->add(__d('content', 'Content Modules'), [
            'url' => $this->Html->Url->build([
                'controller' => 'ContentModules',
                'action' => 'related',
                'Content.Posts', $post->id
            ])
        ]);
    */
    ?>

    <?php
    $this->Tabs->add(__('Debug'), ['debugOnly' => true]);
    debug($post);
    ?>

    <?php echo $this->Tabs->render(); ?>
</div>
