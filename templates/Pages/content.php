<div class="page view container <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">
    <!--
    <h1 class="title"><?= h($page->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($page->published_posts as $page): ?>
            <?php $element = ($page->use_teaser) ? 'request_teaser' : 'request_view'; ?>
            <?= $this->element('Content.Pages/' . $element, ['post' => $page]); ?>
            <?php //debug($page->toArray()); ?>
        <?php endforeach; ?>
    </div>
</div>
