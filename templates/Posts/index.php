<?php $this->Breadcrumbs->add(__d('content', 'Pages')); ?>
<div class="index">
    <?php foreach ($pages as $page) : ?>
        <div class="page-listing">
            <page>
                <h1><?= $this->Html->link($page->title, $page->getUrl()); ?></h1>
                <div class="meta well">
                    <?= h($page->created); ?>
                </div>
                <div class="teaser">
                    <?= $page->excerpt ?>
                </div>
            </page>
            <hr />
        </div>
    <?php endforeach; ?>


    <?= $this->element('Pagination/default'); ?>
</div>