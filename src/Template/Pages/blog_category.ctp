<div class="article view container <?= $article->cssclass ?>" id="<?= $article->cssid; ?>">
    <h1 class="title"><?= h($article->title); ?></h1>

    <div class="posts">
        <?php foreach($articles as $article): ?>
            <?= $this->element('Content.Articles/view', ['post' => $article]); ?>
        <?php endforeach; ?>
    </div>
</div>