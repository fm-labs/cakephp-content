<div class="page view container <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">
    <!--
    <h1 class="title"><?= h($page->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($page->published_posts as $post): ?>
            <?= $this->element('Content.Posts/request_view', ['post' => $post]); ?>
            <?php //debug($post->toArray()); ?>
        <?php endforeach; ?>
    </div>
</div>