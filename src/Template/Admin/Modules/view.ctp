<?php
$this->assign('title', $module->name);

$this->Breadcrumbs->add(__d('content','Modules'), ['action' => 'index']); ?>

<?= $this->Toolbar->addLink(
    __d('content','Edit {0}', __d('content','Module')),
    ['action' => 'edit', $module->id],
    ['data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addPostLink(
    __d('content','Delete {0}', __d('content','Module')),
    ['action' => 'delete', $module->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $module->id)]) ?>

<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Modules')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Module')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','Preview {0}', __d('content','Module')),
    ['action' => 'preview', $module->id],
    ['data-icon' => 'plus', 'target' => 'preview']
) ?>

<div class="modules view">
    <h2 class="ui top attached header">
        <?= h($module->name) ?>
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
            <td><?= __d('content','Name') ?></td>
            <td><?= h($module->name) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Title') ?></td>
            <td><?= h($module->title) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Path') ?></td>
            <td><?= h($module->path) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Entity Class') ?></td>
            <td><?= h(get_class($module)) ?></td>
        </tr>


        <tr>
            <td><?= __d('content','Id') ?></td>
            <td><?= $this->Number->format($module->id) ?></td>
        </tr>


        <tr class="text">

            <td><?= __d('content','Params') ?></td>
            <td><?= $this->Text->autoParagraph(h($module->params)); ?></td>
        </tr>

        <tr class="text">
            <td><?= __d('content','Params ARR') ?></td>
            <td><?= debug($module->params_arr); ?></td>
        </tr>
    </table>

    <?php debug($module); ?>
</div>
