<?php $this->Breadcrumbs->add(__d('content','Pages'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','New {0}', __d('content','Page'))); ?>
<?php
$this->extend('Backend./Admin/Base/form_tabs');
// EXTEND: HEADING
$this->assign('heading', __d('content','Add {0}', __d('content','Page')));
?>
<div class="pages">
    <div class="form">
    <?= $this->Form->create($content, ['class' => 'no-ajax', 'horizontal' => true]); ?>
        <?php
        echo $this->Form->control('parent_id', ['options' => $pagesTree, 'data-placeholder' => 'No parent']);
        echo $this->Form->control('type', ['id' => 'select-type', 'default' => 'content']);
        echo $this->Form->control('title');
        echo $this->Form->hidden('slug');
        echo $this->Form->hidden('is_published', ['value' => false]);
        ?>
    <?= $this->Form->button(__d('content','Submit')) ?>
    <?= $this->Form->end() ?>
    </div>
</div>