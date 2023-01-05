<?php $this->Breadcrumbs->add(__d('content','Pages'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','New {0}', __d('content','Page'))); ?>
<?php
//$this->extend('/Admin/Content/add');
// EXTEND: HEADING
$this->assign('heading', __d('content','Add {0}', __d('content','Page')));
?>
<div class="posts edit form">
    <?= $this->Form->create($page); ?>
    <?php
        echo $this->Form->control('title');
        echo $this->Form->control('type', ['default' => 'page']);
        echo $this->Form->hidden('parent_id');
        echo $this->Form->hidden('refscope');
        echo $this->Form->hidden('refid');
        echo $this->Form->hidden('slug');
        echo $this->Form->hidden('is_published', ['value' => 0]);
    ?>
    <?= $this->Form->button(__d('content','Continue')) ?>
    <?= $this->Form->end() ?>

</div>