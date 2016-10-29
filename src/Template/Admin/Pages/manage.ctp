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

    <?php
    $this->Panel->create();
    $this->Panel->addAction(__d('content', 'Edit'),
        [ 'action' => 'edit', $content->id ],
        [ 'class' => 'link-edit btn btn-default btn-sm', 'data-icon' => 'edit']);
    $this->Panel->addAction(__d('content', 'Change Page Type'),
        [ 'action' => 'editPageType', $content->id ],
        [ 'class' => 'link-edit link-frame-modal btn btn-default btn-sm', 'data-icon' => 'edit']);
    $this->Panel->addAction(__d('content', 'Preview'),
        [ 'action' => 'preview', $content->id ],
        [ 'class' => 'link-preview link-frame-modal btn btn-default btn-sm', 'data-icon' => 'eye', 'target' => '_preview']);
    $this->Panel->addAction(__d('content', 'Delete'),
        [ 'action' => 'delete', $content->id ],
        [ 'class' => 'link-delete btn btn-danger btn-sm',
            'data-icon' => 'trash-o',
            'confirm' => __d('content', 'Sure ?'),
        ]);
    ?>
    <?php $this->Panel->heading(); ?>
        <i class="fa fa-file-o"></i>
        <strong><?= __d('content', 'Page'); ?></strong>
        <?= h($content->title); ?>

    <?php $this->Panel->body(); ?>
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
            'exclude' => '*'
        ]); ?>
    <?= $this->Panel->render(); ?>

    <?php
    $typeElement = 'Content.Admin/Pages/manage_' . $content->type;
    if ($this->elementExists($typeElement)) {
        echo $this->element($typeElement, ['page' => $content]);
    } else {
        echo "Page type element not found: $typeElement";
    }
    ?>

    <!--
    <?= $this->Panel->create(); ?>

            <?php $this->Tabs->start(); ?>
            <?php

            if ($content->type == 'content') {
                $this->Tabs->add(__d('content', 'Posts'), [
                    'url' => ['action' => 'relatedPosts', $content->id]
                ]);
            }

            //$this->Tabs->add(__d('content', 'Edit'), [
            //    'url' => ['action' => 'edit', $content->id]
            //]);

            $this->Tabs->add(__d('content', 'Page Details'), [
                'url' => ['action' => 'view', $content->id]
            ]);

            $this->Tabs->add(__d('content', 'Meta'), [
                'url' => ['action' => 'relatedPageMeta', $content->id]
            ]);

            //$this->Tabs->add(__d('content', 'Sitemap'), [
            //    'url' => ['action' => 'relatedPageMeta', $content->id]
            //]);


            $this->Tabs->add(__d('content', 'Content Modules'), [
                'url' => ['action' => 'relatedContentModules', $content->id]
            ]);
            echo $this->Tabs->render();
            ?>
        </div>
    </div>
    -->


</div>
