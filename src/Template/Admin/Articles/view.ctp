<?php
$this->loadHelper('Bootstrap.Tabs');

// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $article->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $article->id)]
);
$this->Toolbar->addLink(__d('content','Edit'), ['action' => 'edit', $article->id], ['data-icon' => 'edit']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $article->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','List {0}', __d('content','Articles')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Article')), ['action' => 'add'], ['data-icon' => 'plus']);


// HEADING
$this->assign('title', $article->title);

// CONTENT
?>
<div class="view">

    <?php $this->Tabs->start(); ?>
    <!-- Details -->
    <?php $this->Tabs->add(__d('content', 'Details'));
    ?>
    <?= $this->cell('Backend.EntityView', [ $article ], [
        'title' => false,
        'model' => 'Content.Articles'
    ]); ?>

    <!-- Meta -->
    <?php $this->Tabs->add(__d('content', 'Meta')); ?>
    <?= $this->cell('Backend.EntityView', [ $article ], [
        'title' => false,
        'model' => 'Content.Articles',
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
                'Content.Articles', $article->id
            ])
        ]);
    */
    ?>

    <?php
    $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]);
    debug($article);
    ?>

    <?php echo $this->Tabs->render(); ?>
</div>
