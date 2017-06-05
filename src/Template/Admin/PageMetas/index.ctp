<?php $this->Breadcrumbs->add(__d('content', 'Page Metas')); ?>

<?php $this->Toolbar->addLink(__d('content', 'New {0}', __d('content', 'Page Meta')), ['action' => 'add'], ['data-icon' => 'plus']); ?>
<div class="pageMetas index">
    <table class="ui compact table striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('model') ?></th>
            <th><?= $this->Paginator->sort('foreignKey') ?></th>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('robots') ?></th>
            <th><?= $this->Paginator->sort('lang') ?></th>
            <th class="actions"><?= __d('content', 'Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pageMetas as $pageMeta): ?>
        <tr>
            <td><?= $this->Number->format($pageMeta->id) ?></td>
            <td><?= h($pageMeta->model) ?></td>
            <td><?= $this->Number->format($pageMeta->foreignKey) ?></td>
            <td><?= h($pageMeta->title) ?></td>
            <td><?= h($pageMeta->robots) ?></td>
            <td><?= h($pageMeta->lang) ?></td>
            <td class="actions">d
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <?= $this->element('Backend.Pagination/default'); ?>
</div>
