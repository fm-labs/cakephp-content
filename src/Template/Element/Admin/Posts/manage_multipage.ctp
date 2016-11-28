<?php $this->loadHelper('AdminLte.Box'); ?>
<?php $this->loadHelper('Bootstrap.Tabs'); ?>
<style>
    .content.page.manage.posts .panel .panel-body {
        max-height: 300px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
<div class="content page manage posts">
    <?php foreach($post->getChildren() as $post): ?>

    <?= $this->Box->create($post->title, ['collapsed' => true]); ?>

        <?php $this->Tabs->create(); ?>
        <?php $this->Tabs->add('Edit'); ?>
        Edit

        <?php $this->Tabs->add('Preview'); ?>
        <?php echo $this->Content->userHtml($post->body_html); ?>

        <?php echo $this->Tabs->render(); ?>
    <?= $this->Box->render(); ?>
    <?php endforeach; ?>


</div>