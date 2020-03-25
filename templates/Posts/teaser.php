<article class="article teaser">
    <div class="image">
        <?php if ($article->teaser_image): ?>
        <?= $this->Html->image($article->teaser_image->url); ?>
        <?php endif; ?>
    </div>
    <h1 class="title">
        <?= h($article->title); ?>
    </h1>
    <div class="text">
        <?= $this->Content->userHtml($article->teaser_html); ?>
    </div>
    <div class="action">
        <?= $this->Html->link($article->teaser_link_title, $article->teaser_link_url); ?>
    </div>
</article>
