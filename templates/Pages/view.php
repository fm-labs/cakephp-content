<?php
$page = $this->get('page');
?>
<div class="container">
    <article class="post <?= $page->cssclass; ?>" id="<?= $page->cssid ?>">
        <div class="image">
            <?php if ($page->image): ?>
                <?= $this->Html->image($page->image->url, ['class' => 'img-responsive']); ?>
            <?php endif; ?>
        </div>
        <h1 class="title">
            <?= h($page->title); ?>
        </h1>
        <div class="body">
            <?= $this->Content->userHtml($page->body_html); ?>
        </div>
    </article>

    <?php if (\Cake\Core\Configure::read('debug')): ?>
    <hr />
    <div>
        URL: <?= $this->Html->link($page->getViewUrl()); ?><br />
        Perma URL: <?= $this->Html->link($page->getPermaUrl()); ?>
    </div>
    <?php endif; ?>
</div>
