<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($gallery->title); ?>
<?= $this->Toolbar->addLink(
    __d('content','Edit {0}', __d('content','Gallery')),
    ['action' => 'edit', $gallery->id],
    ['data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','Delete {0}', __d('content','Gallery')),
    ['action' => 'delete', $gallery->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $gallery->id)]) ?>

<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Galleries')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Gallery')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->startGroup(__d('content','More')); ?>
<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Posts')),
    ['controller' => 'Posts', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Post')),
    ['controller' => 'Posts', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->endGroup(); ?>
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
    <h4 class="ui header"><?= __d('content','Related {0}', __d('content','Posts')) ?></h4>
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
        <?php foreach ($gallery->posts as $posts): ?>
        <tr>
            <td><?= h($posts->id) ?></td>
            <td><?= h($posts->title) ?></td>
            <td><?= h($posts->image_file) ?></td>
            <td><?= h($posts->template) ?></td>
            <td><?= h($posts->cssclass) ?></td>
            <td><?= h($posts->cssid) ?></td>
            <td><?= h($posts->is_published) ?></td>

            <td class="actions">
                <?= $this->Html->link(__d('content','View'), ['controller' => 'Posts', 'action' => 'view', $posts->id]) ?>

                <?= $this->Html->link(__d('content','Edit'), ['controller' => 'Posts', 'action' => 'edit', $posts->id]) ?>
                <?= $this->Html->link(__d('content','Copy'), ['controller' => 'Posts', 'action' => 'copy', $posts->id]) ?>

                <?= $this->Form->postLink(__d('content','Delete'), ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __d('content','Are you sure you want to delete # {0}?', $posts->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>


    <?= $this->Html->link(__d('content','Add Item'), ['action' => 'addItem', $gallery->id]) ?>
    </div>

    <?php debug($gallery); ?>
</div>
