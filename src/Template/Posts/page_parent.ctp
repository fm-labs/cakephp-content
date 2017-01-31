<?php //$this->Breadcrumbs->add($post->title, $post->view_url); ?>
<div class="page parent view <?= $post->cssclass ?>" id="<?= $post->cssid; ?>">

    <?php if ($post->title): ?>
    <h1 class="title"><?= h($post->title); ?></h1>
    <?php endif; ?>

    <div class="posts">
        <?php foreach($post->getChildren()->find('published')->all()->toArray() as $_post): ?>
        <?= $this->element('Content.Posts/view', ['post' => $_post]); ?>
        <?php endforeach; ?>
    </div>
</div>
