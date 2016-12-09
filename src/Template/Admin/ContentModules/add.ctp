<?php $this->Breadcrumbs->add(__d('content','Content Modules'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','New {0}', __d('content','Content Module'))); ?>
<div class="contentModules">
    <div class="be-toolbar actions">
        <div class="ui secondary menu">
            <div class="item"></div>
            <div class="right menu">
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
        <?= __d('content','Add {0}', __d('content','Content Module')) ?>
    </h2>
    <div class="users ui attached segment">
        <div class="ui form">
        <?php
                echo $this->Form->input('refscope');
                echo $this->Form->input('refid');
                echo $this->Form->input('template');
                echo $this->Form->input('module_id', ['options' => $modules]);
                echo $this->Form->input('section');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>