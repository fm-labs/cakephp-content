<?php $this->Html->addCrumb($page->title, $page->url); ?>
<div class="page view <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">
    <div class="alert alert-info">
        This view is deprecated
    </div>
    <!--
    <h1 class="title"><?= h($page->title); ?></h1>
    -->

    <div class="posts">
        <?php foreach($page->published_posts as $post): ?>
        <?= $this->element('Content.Posts/view', ['post' => $post]); ?>
        <?php endforeach; ?>
    </div>
</div>
