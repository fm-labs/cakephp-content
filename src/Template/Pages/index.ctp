<div class="page index container <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">
    <div class="alert alert-info">Default Page Index</div>
    <!--
    <h1 class="title"><?= h($page->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($page->published_posts as $post): ?>
            <?= $this->element('Content.Posts/request_teaser', ['post' => $post]); ?>
            <?php //debug($post->toArray()); ?>
        <?php endforeach; ?>
    </div>
</div>