<div class="article index container <?= $article->cssclass ?>" id="<?= $article->cssid; ?>">
    <div class="alert alert-info">Default Page Index</div>
    <!--
    <h1 class="title"><?= h($article->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($article->published_posts as $article): ?>
            <?= $this->element('Content.Articles/request_teaser', ['post' => $article]); ?>
            <?php //debug($article->toArray()); ?>
        <?php endforeach; ?>
    </div>
</div>