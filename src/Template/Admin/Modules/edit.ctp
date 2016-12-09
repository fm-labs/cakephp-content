<?php $this->Breadcrumbs->add(__d('content','Modules'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Module'))); ?>
<div class="modules">
    <div class="be-toolbar actions">
        <div class="ui secondary menu">
            <div class="item"></div>
            <div class="right menu">
                <?= $this->Ui->postLink(
                __d('content','Delete'),
                ['action' => 'delete', $module->id],
                ['class' => 'item', 'data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $module->id)]
            )
            ?>
                    <?= $this->Ui->link(
                    __d('content','List {0}', __d('content','Modules')),
                    ['action' => 'index'],
                    ['class' => 'item', 'data-icon' => 'list']
                ) ?>
                <div class="ui dropdown item">
                    <i class="dropdown icon"></i>
                    <i class="setting icon"></i>Actions
                    <div class="menu">
                                <div class="item">No Actions</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui divider"></div>

    <?= $this->Form->create($module); ?>
    <h2 class="ui top attached header">
        <?= __d('content','Edit {0}', __d('content','Module')) ?>
    </h2>
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