<div class="ui form">
    <?= $this->Form->create($contentModule, ['url' => ['action' => 'addContentModule', $contentModule->refid]]); ?>
    <?= $this->Form->control('id'); ?>
    <?= $this->Form->control('refscope', ['value' => 'Content.Pages']); ?>
    <?= $this->Form->control('refid', []); ?>
    <?= $this->Form->control('module_id', ['options' => $availableModules]); ?>
    <?= $this->Form->control('section', ['options' => $sections]); ?>
    <?= $this->Form->submit('Add content module'); ?>
    <?= $this->Form->end(); ?>
</div>

<?php debug($availableModules); ?>