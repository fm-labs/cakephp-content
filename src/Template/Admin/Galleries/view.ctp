<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($gallery->title); ?>
<?php $this->Toolbar->addLink(
    __d('content','Edit {0}', __d('content','Gallery')),
    ['action' => 'edit', $gallery->id],
    ['data-icon' => 'edit']
) ?>
<?php $this->Toolbar->addLink(
    __d('content','Delete {0}', __d('content','Gallery')),
    ['action' => 'delete', $gallery->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $gallery->id)]) ?>

<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Galleries')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Gallery')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->startGroup(__d('content','More')); ?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Articles')),
    ['controller' => 'Articles', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Article')),
    ['controller' => 'Articles', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="galleries view">
    <h2 class="ui header">
        <?= h($gallery->title) ?>
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
            <td><?= __d('content','Title') ?></td>
            <td><?= h($gallery->title) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','View Template') ?></td>
            <td><?= h($gallery->view_template) ?></td>
        </tr>
        <tr>
            <td><?= __d('content','Source') ?></td>
            <td><?= h($gallery->source) ?></td>
        </tr>

        <tr>
            <td><?= __d('content','Source Folder') ?></td>
            <td><?= h($gallery->source_folder) ?></td>
        </tr>



        <tr>
            <td><?= __d('content','Id') ?></td>
            <td><?= $this->Number->format($gallery->id) ?></td>
        </tr>

        <tr class="text">
            <td><?= __d('content','Desc Html') ?></td>
            <td><?= $this->Text->autoParagraph(h($gallery->desc_html)); ?></td>
        </tr>
    </table>
</div>
<div class="related">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __d('content','Related {0}', __d('content','Articles')) ?></h4>
    <?php if (!empty($gallery->posts)): ?>
    <table class="ui table">
        <tr>
            <th><?= __d('content','Id') ?></th>
            <th><?= __d('content','Title') ?></th>
            <th><?= __d('content','Image File') ?></th>
            <th><?= __d('content','Template') ?></th>
            <th><?= __d('content','Cssclass') ?></th>
            <th><?= __d('content','Cssid') ?></th>
            <th><?= __d('content','Published') ?></th>
            <th class="actions"><?= __d('content','Actions') ?></th>
        </tr>
        <?php foreach ($gallery->posts as $articles): ?>
        <tr>
            <td><?= h($articles->id) ?></td>
            <td><?= h($articles->title) ?></td>
            <td><?= h($articles->image_file) ?></td>
            <td><?= h($articles->template) ?></td>
            <td><?= h($articles->cssclass) ?></td>
            <td><?= h($articles->cssid) ?></td>
            <td><?= h($articles->is_published) ?></td>

            <td class="actions">
                <?= $this->Html->link(__d('content','View'), ['controller' => 'Articles', 'action' => 'view', $articles->id]) ?>

                <?= $this->Html->link(__d('content','Edit'), ['controller' => 'Articles', 'action' => 'edit', $articles->id]) ?>
                <?= $this->Html->link(__d('content','Copy'), ['controller' => 'Articles', 'action' => 'copy', $articles->id]) ?>

                <?= $this->Form->postLink(__d('content','Delete'), ['controller' => 'Articles', 'action' => 'delete', $articles->id], ['confirm' => __d('content','Are you sure you want to delete # {0}?', $articles->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>


    <?= $this->Html->link(__d('content','Add Item'), ['action' => 'addItem', $gallery->id]) ?>
    </div>

    <?php debug($gallery); ?>
</div>
