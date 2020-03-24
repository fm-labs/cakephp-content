<div class="view">
    <article class="post <?= $article->cssclass; ?>" id="<?= $article->cssid ?>">
        <h1 class="title">
            <?= h($article->title); ?>
        </h1>
        <div class="image">
            <?php if ($article->image): ?>
                <?= $this->Html->image($article->image->url); ?>
            <?php endif; ?>
        </div>
        <div class="body">
            <?= $this->Content->userHtml($article->body_html); ?>
        </div>
    </article>
</div>