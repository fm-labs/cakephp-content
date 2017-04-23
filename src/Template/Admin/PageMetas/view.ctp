<?php $this->Breadcrumbs->add(__d('content', 'Page Metas'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($pageMeta->title); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'Edit {0}', __d('content', 'Page Meta')),
    ['action' => 'edit', $pageMeta->id],
    ['data-icon' => 'edit']
) ?>
<?php $this->Toolbar->addLink(
    __d('content', 'Delete {0}', __d('content', 'Page Meta')),
    ['action' => 'delete', $pageMeta->id],
    ['data-icon' => 'trash', 'confirm' => __d('content', 'Are you sure you want to delete # {0}?', $pageMeta->id)]) ?>

<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Page Metas')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __d('content', 'New {0}', __d('content', 'Page Meta')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->startGroup(__d('content', 'More')); ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="pageMetas view">
    <h2 class="ui header">
        <?= h($pageMeta->title) ?>
    </h2>
    <table class="ui attached celled striped table">
        <!--
        <thead>
        <tr>
            <th><?= __d('content', 'Label'); ?></th>
            <th><?= __d('content', 'Value'); ?></th>
        </tr>
        </thead>
        -->

        <tr>
            <td><?= __d('content', 'Model') ?></td>
            <td><?= h($pageMeta->model) ?></td>
        </tr>
        <tr>
            <td><?= __d('content', 'Title') ?></td>
            <td><?= h($pageMeta->title) ?></td>
        </tr>
        <tr>
            <td><?= __d('content', 'Robots') ?></td>
            <td><?= h($pageMeta->robots) ?></td>
        </tr>
        <tr>
            <td><?= __d('content', 'Lang') ?></td>
            <td><?= h($pageMeta->lang) ?></td>
        </tr>


        <tr>
            <td><?= __d('content', 'Id') ?></td>
            <td><?= $this->Number->format($pageMeta->id) ?></td>
        </tr>
        <tr>
            <td><?= __d('content', 'ForeignKey') ?></td>
            <td><?= $this->Number->format($pageMeta->foreignKey) ?></td>
        </tr>

        <tr class="text">
            <td><?= __d('content', 'Description') ?></td>
            <td><?= $this->Text->autoParagraph(h($pageMeta->description)); ?></td>
        </tr>
        <tr class="text">
            <td><?= __d('content', 'Keywords') ?></td>
            <td><?= $this->Text->autoParagraph(h($pageMeta->keywords)); ?></td>
        </tr>
    </table>
</div>
