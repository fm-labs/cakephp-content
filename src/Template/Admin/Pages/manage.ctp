<?php
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

    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-page"></i>
            <strong><?= __d('content', 'Page'); ?></strong>
            <?= h($content->title); ?>
        </div>
        <div class="panel-body">

            Public URL:
            <?= $this->Ui->link(
                $this->Html->Url->build($content->url, true),
                $content->url,
                ['target' => '_blank', 'data-icon' => 'external']
            ); ?>
            <div class="actions">

                <?= $this->Html->link(__d('content', 'Edit {0}', __d('content', 'Page')),
                    [ 'action' => 'edit', $content->id ],
                    [ 'class' => 'edit link-frame-modal btn btn-primary btn-sm', 'data-icon' => 'edit']);
                ?>
            </div>
        </div>
        <div class="panel-body">


            <?php $this->Tabs->start(); ?>
            <?php

            if ($content->type == 'content') {
                $this->Tabs->add(__d('content', 'Posts'), [
                    'url' => ['action' => 'relatedPosts', $content->id]
                ]);
            }

            $this->Tabs->add(__d('content', 'Meta'), [
                'url' => ['action' => 'relatedPageMeta', $content->id]
            ]);

            //$this->Tabs->add(__d('content', 'Sitemap'), [
            //    'url' => ['action' => 'relatedPageMeta', $content->id]
            //]);

            $this->Tabs->add(__d('content', 'Page Details'), [
                'url' => ['action' => 'view', $content->id]
            ]);

            $this->Tabs->add(__d('content', 'Content Modules'), [
                'url' => ['action' => 'relatedContentModules', $content->id]
            ]);
            echo $this->Tabs->render();
            ?>
        </div>
    </div>


</div>
