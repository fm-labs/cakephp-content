<?php $this->Html->addCrumb(__d('content','Content Modules'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb($contentModule->id); ?>
<div class="be-toolbar actions">
    <div class="ui secondary menu">
        <div class="item"></div>
        <div class="right menu">
            <?= $this->Ui->link(
                __d('content','Edit {0}', __d('content','Content Module')),
                ['action' => 'edit', $contentModule->id],
                ['class' => 'item', 'data-icon' => 'edit']
            ) ?>
            <?= $this->Ui->postLink(
                __d('content','Delete {0}', __d('content','Content Module')),
                ['action' => 'delete', $contentModule->id],
                ['class' => 'item', 'data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $contentModule->id)]) ?>

            <?= $this->Ui->link(
                __d('content','List {0}', __d('content','Content Modules')),
                ['action' => 'index'],
                ['class' => 'item', 'data-icon' => 'list']
            ) ?>
            <?= $this->Ui->link(
                __d('content','New {0}', __d('content','Content Module')),
                ['action' => 'add'],
                ['class' => 'item', 'data-icon' => 'plus']
            ) ?>
            <div class="ui item dropdown">
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

<div class="contentModules view">
    <h2 class="ui top attached header">
        <?= h($contentModule->id) ?>
    </h2>
    <table class="ui attached celled striped table">
        <!--
        <thead>
        <tr>
            <th><?= __d('content','Label'); ?></th>
            <th><?= __d('content','Value'); ?></th>
        </tr>
        </thead>
        -->

        <tr>
            <td><?= __d('content','Refscope') ?></td>
            <td><?= h($contentModule->refscope) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Module') ?></td>
            <td><?= $contentModule->has('module') ? $this->Html->link($contentModule->module->name, ['controller' => 'Modules', 'action' => 'view', $contentModule->module->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Section') ?></td>
            <td><?= h($contentModule->section) ?></td>
        </tr>


        <tr>
            <td><?= __d('content','Id') ?></td>
            <td><?= $this->Number->format($contentModule->id) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Refid') ?></td>
            <td><?= $this->Number->format($contentModule->refid) ?></td>
        </tr>

    </table>
</div>
