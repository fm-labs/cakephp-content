<?php
// Breadcrumbs
$this->Breadcrumbs->add(__('Pages'), ['action' => 'index', 'type' => $post->type]);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Page')));
// Heading
$this->assign('title', $post->title);
?>
<?php $this->loadHelper('AdminLte.Box'); ?>
<?php $this->loadHelper('Bootstrap.Ui'); ?>
<?php $this->loadHelper('Bootstrap.Tabs'); ?>
<style>
    .content.page.manage.posts .panel .panel-body {
        max-height: 300px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
<?= $this->Form->create($post); ?>
<?php
echo $this->Form->hidden('type');
echo $this->Form->input('title');
echo $this->Form->input('slug');
?>
<?= $this->Form->button(__('Save changes')); ?>
<?= $this->Form->end(); ?>

<h2>Posts</h2>
<div class="content page manage posts">
    <?php foreach($post->getChildren() as $_post): ?>

    <?= $this->Box->create(['collapsed' => true]); ?>
        <!-- Box Heading -->
        <?= $this->Box->heading(); ?>
        <?= h($_post->title); ?>
        <?= $this->Ui->statusLabel($_post->is_published, [], [
            0 => [__('Unpublished'), 'default'],
            1 => [__('Published'), 'success']
        ]); ?>
        <?= $this->Html->link('Edit Post', ['plugin' => 'content', 'controller' => 'Posts', 'action' => 'edit', $_post->id], ['class' => 'btn btn-sm']); ?>

        <!-- Box Body -->
        <?= $this->Box->body(); ?>

        <!-- Tab Quick Edit -->
        <?php $this->Tabs->create(); ?>
        <?php $this->Tabs->add('Quick Edit'); ?>

        <?= $this->Form->create($_post, ['data-ajax' => 1, 'url' => ['action' => 'edit', 'parent_id' => $post->id, '_ext' => 'json']]); ?>
        <?= $this->Form->hidden('id'); ?>
        <?= $this->Form->hidden('type'); ?>
        <?= $this->Form->input('title'); ?>
        <?= $this->Form->input('body_html', [
            'type' => 'htmleditor',
            'editor' => $editor
        ]); ?>
        <?= $this->Form->button(__('Save')); ?>
        <?= $this->Form->end(); ?>

        <!-- Tab Preview -->
        <?php $this->Tabs->add('Preview'); ?>
        <div class="page-preview">
            <?php echo $this->Content->userHtml($_post->body_html); ?>
        </div>

        <?php echo $this->Tabs->render(); ?>
    <?= $this->Box->render(); ?>
    <?php endforeach; ?>
</div>
