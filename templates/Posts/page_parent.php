<?php //$this->Breadcrumbs->add($page->title, $page->view_url); ?>
<div class="page parent view <?= $page->cssclass ?>" id="<?= $page->cssid; ?>">

    <?php if ($page->title): ?>
    <h1 class="title"><?= h($page->title); ?></h1>
    <?php endif; ?>

    <div class="pages">
        <?php foreach($page->getChildren()->find('published')->all()->toArray() as $_page): ?>
        <?= $this->element('Content.Pages/view', ['page' => $_page]); ?>
        <?php endforeach; ?>
    </div>
</div>
