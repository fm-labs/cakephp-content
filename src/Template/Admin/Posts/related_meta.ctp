<?= $this->Form->create($pageMeta, ['class' => 'form-ajax']); ?>
<?php
echo $this->Form->hidden('model');
echo $this->Form->hidden('foreignKey');
echo $this->Form->control('title');
echo $this->Form->control('description');
echo $this->Form->control('keywords');
echo $this->Form->control('robots');
echo $this->Form->control('lang');
?>
<?= $this->Form->button(__d('content', 'Submit')) ?>
<?= $this->Form->end(); ?>
