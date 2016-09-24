<?php $this->Html->addCrumb(__d('content','Pages'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','Edit {0}', __d('content','Content Module'))); ?>
<?php $this->extend('/Admin/Content/edit_module'); ?>