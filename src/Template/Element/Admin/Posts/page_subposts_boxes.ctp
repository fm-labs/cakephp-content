
<?php foreach($post->children as $_post): ?>

    <?= $this->Box->create(['collapsed' => true]); ?>
    <!-- Box Heading -->
    <?= $this->Box->heading(); ?>
    <?= h($_post->title); ?>
    <br />
    <?= $this->Ui->statusLabel($_post->is_published, [], [
        0 => [__d('content', 'Unpublished'), 'default'],
        1 => [__d('content', 'Published'), 'success']
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
    <?= $this->Form->control('title'); ?>
    <?= $this->Form->control('body_html', [
        'type' => 'htmleditor',
        'editor' => $editor
    ]); ?>
    <?= $this->Form->button(__d('content', 'Save')); ?>
    <?= $this->Form->end(); ?>

    <!-- Tab Preview -->
    <?php $this->Tabs->add('Preview'); ?>
    <div class="page-preview">
        <?php echo $this->Content->userHtml($_post->body_html); ?>
    </div>

    <?php echo $this->Tabs->render(); ?>
    <?= $this->Box->render(); ?>
<?php endforeach; ?>