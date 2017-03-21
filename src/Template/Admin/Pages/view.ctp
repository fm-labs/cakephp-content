<?php
$this->loadHelper('Bootstrap.Panel');
$this->loadHelper('Bootstrap.Tabs');
//$this->extend('/Admin/Content/edit');

// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $content->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $content->id)]
);
$this->Toolbar->addLink(__d('content','Edit {0}', __d('content','Page')), ['action' => 'edit', $content->id], ['data-icon' => 'edit']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $content->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','List {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);


// HEADING
$this->assign('title', $content->title);

// CONTENT
?>
<div class="pages">

    <?php $this->Tabs->start(); ?>

    <!-- Related posts -->
    <?php
    if ($content->type == 'content') {
        $this->Tabs->add(__d('content', 'Posts'), [
            'url' => ['action' => 'relatedPosts', $content->id]
        ]);
    }
    ?>

    <!-- Details -->
    <?php $this->Tabs->add(__d('content', 'Page Details')); ?>
    <?= $this->cell('Backend.EntityView', [ $content ], [
        'title' => false,
        'model' => 'Content.Pages',
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
        'exclude' => ['lft', 'rght']
    ]); ?>

    <?php
    $this->Tabs->add(__d('content', 'Meta'), [
        'url' => ['action' => 'relatedPageMeta', $content->id]
    ]);

    $this->Tabs->add(__d('content', 'Content Modules'), [
        'url' => ['action' => 'relatedContentModules', $content->id]
    ]);

    $this->Tabs->add(__('Debug'), ['debugOnly' => true]);
    debug($content);
    ?>

    <?php echo $this->Tabs->render(); ?>
</div>
