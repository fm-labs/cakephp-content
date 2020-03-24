<div class="article view container <?= $article->cssclass ?>" id="<?= $article->cssid; ?>">
    <!--
    <h1 class="title"><?= h($article->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($article->published_posts as $article): ?>
            <?php $element = ($article->use_teaser) ? 'request_teaser' : 'request_view'; ?>
            <?= $this->element('Content.Articles/' . $element, ['post' => $article]); ?>
            <?php //debug($article->toArray()); ?>
        <?php endforeach; ?>
    </div>
</div>
