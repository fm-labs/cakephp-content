<?php //$this->Breadcrumbs->add($article->title, $article->view_url); ?>
<div class="page parent view <?= $article->cssclass ?>" id="<?= $article->cssid; ?>">

    <?php if ($article->title): ?>
    <h1 class="title"><?= h($article->title); ?></h1>
    <?php endif; ?>

    <div class="articles">
        <?php foreach($article->getChildren()->find('published')->all()->toArray() as $_article): ?>
        <?= $this->element('Content.Articles/view', ['article' => $_article]); ?>
        <?php endforeach; ?>
    </div>
</div>
