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
            <i class="fa fa-file-o"></i>
            <strong><?= __d('content', 'Page'); ?></strong>
            <?= h($content->title); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-8">
                    Page Type: <?= h($content->type); ?> <?= $this->Html->link(__('Change type'), ['action' => 'editPageType']); ?>
                    <br />
                    Public URL:
                    <?= $this->Ui->link(
                        $this->Html->Url->build($content->url, true),
                        $content->url,
                        ['target' => '_blank', 'data-icon' => 'external']
                    ); ?>
                </div>
                <div class="col-md-4">
                    <div class="actions right grouped">
                        <ul>
                            <li><?= $this->Html->link(__d('content', 'Edit'),
                                    [ 'action' => 'edit', $content->id ],
                                    [ 'class' => 'edit link-frame-modal btn btn-primary btn-sm', 'data-icon' => 'edit']);
                                ?>
                            </li>
                            <li><?= $this->Html->link(__d('content', 'Preview'),
                                    [ 'action' => 'preview', $content->id ],
                                    [ 'class' => 'preview link-frame-modal btn btn-primary btn-sm', 'data-icon' => 'eye', 'target' => '_preview']);
                                ?>
                            </li>
                            <li><?= $this->Html->link(__d('content', 'Delete'),
                                    [ 'action' => 'delete', $content->id ],
                                    [ 'class' => 'delete btn btn-danger btn-sm',
                                        'data-icon' => 'trash-o',
                                        'confirm' => __d('content', 'Sure ?'),
                                    ]);
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
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

            $this->Tabs->add(__d('content', 'Edit'), [
                'url' => ['action' => 'edit', $content->id]
            ]);

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


</div>
