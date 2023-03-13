<?php
$this->loadHelper('Bootstrap.Tabs');

// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $page->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $page->id)]
);
$this->Toolbar->addLink(__d('content','Edit'), ['action' => 'edit', $page->id], ['data-icon' => 'edit']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $page->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','List {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);


// HEADING
$this->assign('title', $page->title);

// CONTENT
?>
<div class="view">

    <?php $this->Tabs->start(); ?>
    <!-- Details -->
    <?php $this->Tabs->add(__d('content', 'Details'));
    ?>
    <?= $this->cell('Admin.EntityView', [ $page ], [
        'title' => false,
        'model' => 'Content.Pages'
    ])->render('table'); ?>

    <!-- Meta -->
    <?php /* $this->Tabs->add(__d('content', 'Meta')); ?>
    <?= $this->cell('Admin.EntityView', [ $page ], [
        'title' => false,
        'model' => 'Content.Pages',
        'fields' => [
            'meta_title',
            'meta_desc',
            'meta_robots',
            'meta_lang'
        ],
        'exclude' => '*'
    ])->render('table'); */ ?>

    <!-- Content Modules -->
    <?php
    /*
    $this->Tabs->add(__d('content', 'Content Modules'), [
            'url' => $this->Html->Url->build([
                'controller' => 'ContentModules',
                'action' => 'related',
                'Content.Pages', $page->id
            ])
        ]);
    */
    ?>

    <?php
    $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]);
    debug($page);
    ?>

    <?php echo $this->Tabs->render(); ?>
</div>
