<div class="view container">
    <article class="post <?= $page->cssclass; ?>" id="<?= $page->cssid ?>">
        <h1 class="title">
            <?= h($page->title); ?>
        </h1>
        <div class="image">
            <?php if ($page->image): ?>
                <?= $this->Html->image($page->image->url); ?>
            <?php endif; ?>
        </div>
        <div class="body">
            <?= $this->Content->userHtml($page->body_html); ?>
        </div>
    </article>
</div>