<?php $this->Breadcrumbs->add(__d('content','Modules'), ['action' => 'index']); ?>
<?php $this->assign('title', $module->name); ?>

<?php $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $module->id],
    ['class' => 'item', 'data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $module->id)]
)
?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Modules')),
    ['action' => 'index'],
    ['class' => 'item', 'data-icon' => 'list']
) ?>
<div class="modules">
    <?= $this->Form->create($module); ?>

    <div class="users ui attached segment">
        <div class="ui form">
        <?php
                echo $this->Form->input('name');
                echo $this->Form->input('title');
                echo $this->Form->input('path');
                echo $this->Form->input('params');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>