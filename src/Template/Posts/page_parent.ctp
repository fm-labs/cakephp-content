<?php $this->Html->addCrumb($post->title, $post->view_url); ?>
<div class="page parent view <?= $post->cssclass ?>" id="<?= $post->cssid; ?>">

    <?php if ($post->title): ?>
    <h1 class="title"><?= h($page->title); ?></h1>
    <?php endif; ?>

    <div class="posts">
        <?php foreach($post->getChildren()->find('published')->all()->toArray() as $post): ?>
        <?= $this->element('Content.Posts/view', ['post' => $post]); ?>
        <?php endforeach; ?>
    </div>
</div>
