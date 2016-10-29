<div>
    <?= $this->Panel->create() ?>
    <?= $this->Panel->body(); ?>
    Redirects to
    <?= $this->Html->link($page->redirect_location, $page->redirect_location, ['target' => '_blank']); ?>
    [<?= h($page->redirect_status); ?>]
    <?= $this->Panel->render(); ?>
</div>