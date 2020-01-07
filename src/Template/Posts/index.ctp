<?php $this->Breadcrumbs->add(__d('content','Posts')); ?>
<div class="index container">
    <?php foreach ($posts as $post) : ?>
        <div class="post-listing">
            <article>
                <h1><?= $this->Html->link($post->title, $post->getUrl()); ?></h1>
                <div class="teaser">
                    <?= $post->excerpt_html; ?>
                </div>
            </article>
            <hr />
        </div>
    <?php endforeach; ?>


    <?= $this->element('Pagination/default'); ?>
<div>