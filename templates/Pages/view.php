<?php
$page = $this->get('page');
?>
<div class="view">
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
</div>