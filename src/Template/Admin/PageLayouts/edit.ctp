<?php $this->Html->addCrumb(__d('content','Page Layouts'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','Edit {0}', __d('content','Page Layout'))); ?>
<?= $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $pageLayout->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $pageLayout->id)]
)
?>
<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Page Layouts')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __d('content','Edit {0}', __d('content','Page Layout')) ?>
    </h2>
    <?= $this->Form->create($pageLayout); ?>
    <div class="users ui basic segment">
        <div class="ui form">
        <?php
                echo $this->Form->input('name');
                echo $this->Form->input('template');
                echo $this->Form->input('sections');
                echo $this->Form->input('is_default');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>