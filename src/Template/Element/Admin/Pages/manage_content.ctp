<?php $this->loadHelper('Bootstrap.Panel'); ?>
<style>
    .content.page.manage.posts .panel .panel-body {
        max-height: 300px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
<div class="content page manage posts">
    <h1><?= __('Posts for {0}', $page->title); ?></h1>
    <?php foreach($page->posts as $post): ?>
    <?php
        $class = '';
        $class .= ($post->is_published) ? 'panel-success published' : 'panel-danger unpublished';
    ?>
    <?= $this->Panel->create(['class' => $class]); ?>
        <?= $this->Panel->heading($post->title); ?>
        <?= $this->Panel->body(); ?>
        <?= $this->Content->userHtml($post->body_html); ?>
        <?= $this->Panel->addAction('Edit', ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'btn btn-default link-edit']); ?>
        <?= $this->Panel->render(); ?>
    <?php endforeach; ?>
    <?php debug($page->posts); ?>
</div>