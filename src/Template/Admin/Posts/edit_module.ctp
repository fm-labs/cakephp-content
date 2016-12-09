<?php $this->Breadcrumbs->add(__d('content','Pages'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Content Module'))); ?>
<?php $this->extend('/Admin/Content/edit_module'); ?>