<?php $this->Breadcrumbs->add(__d('content','Articles')); ?>
<div class="index">
    <?php foreach ($articles as $article) : ?>
        <div class="article-listing">
            <article>
                <h1><?= $this->Html->link($article->title, $article->getUrl()); ?></h1>
                <div class="meta well">
                    <?= h($article->created); ?>
                </div>
                <div class="teaser">
                    <?= $article->excerpt_html; ?>
                </div>
            </article>
            <hr />
        </div>
    <?php endforeach; ?>


    <?= $this->element('Pagination/default'); ?>
</div>