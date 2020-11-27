<?php $this->loadHelper('Content.Content'); ?>
<div class="view">
    <div class="page">
        <h1><?= h($page->title); ?></h1>
        <div class="html">
            <?= $this->Content->userHtml($page->excerpt); ?>
            <hr />
            <?= $this->Content->userHtml($page->body_html); ?>
        </div>
        <?php //debug($page); ?>
    </div>
</div>