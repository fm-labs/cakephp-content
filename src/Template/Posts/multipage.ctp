<?php $this->Html->addCrumb($post->title, $post->view_url); ?>
<div class="page multipage view <?= $post->cssclass ?>" id="<?= $post->cssid; ?>">

    <?php if ($post->title): ?>
    <h1 class="title"><?= h($page->title); ?></h1>
    <?php endif; ?>

    <div class="posts">
        <?php foreach($post->getChildren() as $post): ?>
        <?= $this->element('Content.Posts/view', ['post' => $post]); ?>
        <?php endforeach; ?>
    </div>
</div>
