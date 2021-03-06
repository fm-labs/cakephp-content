<?php

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $page->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addLink([
    'title' => __d('content','List {0}', __d('content','Pages')),
    'url' => ['action' => 'index'],
    'attr' => ['data-icon' => 'list']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $page->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $page->id)],
]);
?>
<?php
$this->assign('title', __d('content', 'Galleries'));
$this->assign('heading', $gallery->title);
$this->assign('subheading', 'Gallery post');
?>
<?= $this->Form->create($page); ?>
<div class="clearfix clear-fix" style="clear: both;"></div>
<div class="row">
    <div class="col-md-9">
        <?php
        echo $this->Form->hidden('type');
        echo $this->Form->control('title');
        echo $this->Form->hidden('slug', ['value' => null]);
        //echo $this->Form->control('subheading');
        ?>
        <?= $this->Html->link(__d('content', 'Edit parent gallery'), ['controller' => 'Galleries', 'action' => 'manage', $page->refid]); ?>

        <?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
        <?php
        echo $this->Form->control('body_html', [
            'type' => 'htmleditor',
            'editor' => $editor
        ]);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

    </div>
    <div class="col-md-3">

        <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary btn-block']) ?>

        <!-- Publish -->
        <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
        <?php
        echo $this->Form->control('is_published');
        echo $this->Form->control('publish_start_date', ['type' => 'datepicker']);
        echo $this->Form->control('publish_end_date', ['type' => 'datepicker']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <!-- Media -->
        <?= $this->Form->fieldsetStart(['legend' => 'Media', 'collapsed' => false]); ?>
        <?= $this->Form->control('image_file', ['type' => 'media_picker', 'config' => 'images']); ?>
        <?= $this->Form->fieldsetEnd(); ?>


        <!-- Advanced -->
        <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => true]); ?>
            <?php
            echo $this->Form->control('refscope');
            echo $this->Form->control('refid');
            echo $this->Form->control('cssclass');
            echo $this->Form->control('cssid');
            echo $this->Form->control('pos', ['readonly' => true]);
            ?>
        <?= $this->Form->fieldsetEnd(); ?>
    </div>
</div>
<?= $this->Form->end() ?>