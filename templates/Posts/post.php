<?php
$page = $this->get('page');
?>
<div class="view">
    <page class="page <?= $page->cssclass; ?>" id="<?= $page->cssid ?>">
        <div class="image">
            <?php if ($page->image) : ?>
                <?= $this->Html->image($page->image->url, ['class' => 'img-responsive']); ?>
            <?php endif; ?>
        </div>
        <h1 class="title">
            <?= h($page->title); ?>
        </h1>
        <div class="meta">
            <?= h($page->created); ?>
        </div>
        <hr />
        <div class="body">
            <?= $this->Content->userHtml($page->body_html); ?>
        </div>
    </page>


    <div class="page-info well">
        <p>
            <span class="page-info-title">Canonical URL</span>
            <span class="page-info-data"><?= $this->Html->link($page->getViewUrl()); ?></span>
        </p>
        <p>
            <span class="page-info-title">Perma URL</span>
            <span class="page-info-data"><?= $this->Html->link($page->getPermaUrl()); ?></span>
        </p>
    </div>
</div>