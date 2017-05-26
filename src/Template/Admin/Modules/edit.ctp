<?php $this->Breadcrumbs->add(__d('content','Modules'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit')); ?>

<?php $this->Toolbar->addLink(
    __d('content','Configure'),
    ['action' => 'configure', $module->id],
    ['class' => 'item', 'data-icon' => 'gear']
) ?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Modules')),
    ['action' => 'index'],
    ['class' => 'item', 'data-icon' => 'list']
) ?>
<?php $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $module->id],
    ['class' => 'item', 'data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $module->id)]
)
?>
<div class="modules">
    <?= $this->Form->create($module); ?>

    <div class="users ui attached segment">
        <div class="ui form">
        <?php
                echo $this->Form->input('name');
                //echo $this->Form->input('title');
                echo $this->Form->input('path');
                echo $this->Form->input('params');
        ?>
            <p>
                <?= $this->Html->link(__d('content', 'Open configuration editor'), ['action' => 'configure', $module->id]); ?>
                <br />
                <strong><?= __d('content', 'Attention'); ?></strong> It is not recommendet to edit params directly in the editor. Just be careful to provide valid JSON.
            </p>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>