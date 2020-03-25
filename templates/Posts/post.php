<div class="view">
    <article class="article <?= $article->cssclass; ?>" id="<?= $article->cssid ?>">
        <h1 class="title">
            <?= h($article->title); ?>
        </h1>
        <div class="image">
            <?php if ($article->image): ?>
                <?= $this->Html->image($article->image->url); ?>
            <?php endif; ?>
        </div>
        <div class="meta well">
            <?= h($article->created); ?>
        </div>
        <div class="body">
            <?= $this->Content->userHtml($article->body_html); ?>
        </div>
    </article>


    <div class="article-info well">
        <p>
            <span class="article-info-title">Canonical URL</span>
            <span class="article-info-data"><?= $this->Html->link($article->getViewUrl()); ?></span>
        </p>
        <p>
            <span class="article-info-title">Perma URL</span>
            <span class="article-info-data"><?= $this->Html->link($article->getPermaUrl()); ?></span>
        </p>
    </div>
</div>