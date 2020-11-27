<div class="page index container <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">
    <div class="alert alert-info">Default Page Index</div>
    <!--
    <h1 class="title"><?= h($page->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($page->published_posts as $page): ?>
            <?= $this->element('Content.Pages/request_teaser', ['post' => $page]); ?>
            <?php //debug($page->toArray()); ?>
        <?php endforeach; ?>
    </div>
</div>