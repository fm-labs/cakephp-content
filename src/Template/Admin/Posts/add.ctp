<?php $this->Html->addCrumb(__d('content','Posts'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','New {0}', __d('content','Post'))); ?>
<?php
$this->extend('/Admin/Content/add');
// EXTEND: HEADING
$this->assign('heading', __d('content','Add {0}', __d('content','Post')));
?>
<div class="posts">
    <?php var_dump($content->errors()); ?>
    <?= $this->Form->create($content, ['class' => 'no-ajax']); ?>
    <div class="users ui top attached segment">
        <div class="ui form">
        <?php
            echo $this->Form->input('title');
            echo $this->Form->hidden('refscope');
            echo $this->Form->hidden('refid');
            echo $this->Form->hidden('slug');
            echo $this->Form->hidden('is_published', ['value' => 0]);
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Continue')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>