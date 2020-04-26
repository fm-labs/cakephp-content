<?php
$article = $this->get('article');
?>
<div class="view">
    <article class="post <?= $article->cssclass; ?>" id="<?= $article->cssid ?>">
        <div class="image">
            <?php if ($article->image): ?>
                <?= $this->Html->image($article->image->url, ['class' => 'img-responsive']); ?>
            <?php endif; ?>
        </div>
        <h1 class="title">
            <?= h($article->title); ?>
        </h1>
        <div class="body">
            <?= $this->Content->userHtml($article->body_html); ?>
        </div>
    </article>
</div>