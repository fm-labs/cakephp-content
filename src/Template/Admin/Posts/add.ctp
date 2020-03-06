<?php $this->Breadcrumbs->add(__d('content','Posts'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','New {0}', __d('content','Post'))); ?>
<?php
//$this->extend('/Admin/Content/add');
// EXTEND: HEADING
$this->assign('heading', __d('content','Add {0}', __d('content','Post')));
?>
<div class="posts">
    <?= $this->Form->create($post); ?>
    <?php
        echo $this->Form->control('title');
        echo $this->Form->control('type', ['default' => 'post']);
        echo $this->Form->hidden('parent_id');
        echo $this->Form->hidden('refscope');
        echo $this->Form->hidden('refid');
        echo $this->Form->hidden('slug');
        echo $this->Form->hidden('is_published', ['value' => 0]);
    ?>
    <?= $this->Form->button(__d('content','Continue')) ?>
    <?= $this->Form->end() ?>

</div>