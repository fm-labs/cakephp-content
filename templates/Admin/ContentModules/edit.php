<?php $this->Breadcrumbs->add(__d('content','Content Modules'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Content Module'))); ?>
<div class="contentModules">
    <div class="be-toolbar actions">
        <div class="ui secondary menu">
            <div class="item"></div>
            <div class="right menu">
                <?= $this->Ui->postLink(
                __d('content','Delete'),
                ['action' => 'delete', $contentModule->id],
                ['class' => 'item', 'data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $contentModule->id)]
            )
            ?>
                    <?= $this->Ui->link(
                    __d('content','List {0}', __d('content','Content Modules')),
                    ['action' => 'index'],
                    ['class' => 'item', 'data-icon' => 'list']
                ) ?>
                <div class="ui dropdown item">
                    <i class="dropdown icon"></i>
                    <i class="setting icon"></i>Actions
                    <div class="menu">
    
                        <?= $this->Ui->link(
                            __d('content','List {0}', __d('content','Modules')),
                            ['controller' => 'Modules', 'action' => 'index'],
                            ['class' => 'item', 'data-icon' => 'list']
                        ) ?>

                        <?= $this->Ui->link(
                            __d('content','New {0}', __d('content','Module')),
                            ['controller' => 'Modules', 'action' => 'add'],
                            ['class' => 'item', 'data-icon' => 'plus']
                        ) ?>
                            </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui divider"></div>

    <?= $this->Form->create($contentModule); ?>
    <h2 class="ui top attached header">
        <?= __d('content','Edit {0}', __d('content','Content Module')) ?>
    </h2>
    <div class="users ui attached segment">
        <div class="ui form">
        <?php
                echo $this->Form->control('refscope');
                echo $this->Form->control('refid');
                echo $this->Form->control('template');
                echo $this->Form->control('module_id', ['options' => $modules]);
                echo $this->Form->control('section');
                echo $this->Form->control('cssid');
                echo $this->Form->control('cssclass');
                echo $this->Form->control('priority');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>