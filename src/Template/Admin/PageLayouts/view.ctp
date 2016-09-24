<?php $this->Html->addCrumb(__d('content','Page Layouts'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb($pageLayout->name); ?>
<?= $this->Toolbar->addLink(
    __d('content','Edit {0}', __d('content','Page Layout')),
    ['action' => 'edit', $pageLayout->id],
    ['data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','Delete {0}', __d('content','Page Layout')),
    ['action' => 'delete', $pageLayout->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $pageLayout->id)]) ?>

<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Page Layouts')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Page Layout')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->startGroup(__d('content','More')); ?>
<?= $this->Toolbar->endGroup(); ?>
<div class="pageLayouts view">
    <h2 class="ui header">
        <?= h($pageLayout->name) ?>
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
            <td><?= h($pageLayout->name) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Template') ?></td>
            <td><?= h($pageLayout->template) ?></td>
        </tr>


        <tr>
            <td><?= __d('content','Id') ?></td>
            <td><?= $this->Number->format($pageLayout->id) ?></td>
        </tr>

        <tr class="boolean">
            <td><?= __d('content','Is Default') ?></td>
            <td><?= $pageLayout->is_default ? __d('content','Yes') : __d('content','No'); ?></td>
        </tr>
        <tr class="text">
            <td><?= __d('content','Sections') ?></td>
            <td><?= $this->Text->autoParagraph(h($pageLayout->sections)); ?></td>
        </tr>
    </table>
</div>
