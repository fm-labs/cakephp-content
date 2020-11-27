<div class="page view container <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">
    <!--
    <h1 class="title"><?= h($page->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($page->published_posts as $page): ?>
            <?= $this->element('Content.Pages/request_teaser', ['post' => $page]); ?>
        <?php endforeach; ?>
    </div>
</div>
