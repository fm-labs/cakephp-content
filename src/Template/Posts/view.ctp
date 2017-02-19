<?php $this->loadHelper('Content.Content'); ?>
<div class="post">
    <h1><?= h($post->title); ?></h1>
    <div class="html">
        <?= $this->Content->userHtml($post->teaser_html); ?>
        <hr />
        <?= $this->Content->userHtml($post->body_html); ?>
    </div>
    <?php //debug($post); ?>
</div>