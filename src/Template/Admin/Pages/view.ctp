<?php
$this->Html->addCrumb(__d('content', 'Pages'), ['action' => 'index']);
$this->Html->addCrumb(__d('content','Edit {0}', $content->title));

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
<div class="pages view">

    <?= $this->cell('Backend.EntityView', [ $content ], [
        'title' => false,
        'model' => 'Content.Pages',
        'fields' => [
            'title' => [
                'formatter' => function($val, $entity) {
                    return $this->Html->link($val, ['action' => 'edit', $entity->id], ['class' => 'link-frame']);
                }
            ],
            'parent_id' => [
                'title' => __d('content', 'Parent Page'),
                'formatter' => function($val, $entity) {
                    if (!$entity->parent_id) {
                        return __d('content', 'Root Page');
                    }

                    $title = ($entity->parent_page) ? $entity->parent_page->title : $entity->parent_id;
                    return $this->Html->link($title, ['action' => 'view', $entity->id], ['class' => 'link-frame']);
                }
            ],
            'is_published' => ['formatter' => 'boolean'],
            'url' => [
                'formatter' => ['link' => ['target' => '_blank']]
            ]
        ],
        'exclude' => ['id', 'level', 'lft', 'rght', 'meta', 'meta_lang', 'meta_title', 'meta_desc', 'meta_keywords', 'meta_robots', 'parent_page', 'content_modules', 'posts']
    ]); ?>
</div>
