<?php $this->loadHelper('Content.Content'); ?>
<div class="view">
    <div class="article">
        <h1><?= h($article->title); ?></h1>
        <div class="html">
            <?= $this->Content->userHtml($article->teaser_html); ?>
            <hr />
            <?= $this->Content->userHtml($article->body_html); ?>
        </div>
        <?php //debug($article); ?>
    </div>
</div>