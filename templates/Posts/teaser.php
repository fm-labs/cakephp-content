<page class="page teaser">
    <div class="image">
        <?php if ($page->teaser_image): ?>
        <?= $this->Html->image($page->teaser_image->url); ?>
        <?php endif; ?>
    </div>
    <h1 class="title">
        <?= h($page->title); ?>
    </h1>
    <div class="text">
        <?= $this->Content->userHtml($page->teaser_html); ?>
    </div>
    <div class="action">
        <?= $this->Html->link($page->teaser_link_title, $page->teaser_link_url); ?>
    </div>
</page>
