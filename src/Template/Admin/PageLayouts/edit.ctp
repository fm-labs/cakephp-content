<?php $this->Breadcrumbs->add(__d('content','Page Layouts'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Page Layout'))); ?>
<?php $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $pageLayout->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $pageLayout->id)]
)
?>
<?php $this->Toolbar->addLink(
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
                echo $this->Form->control('name');
                echo $this->Form->control('template');
                echo $this->Form->control('sections');
                echo $this->Form->control('is_default');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>