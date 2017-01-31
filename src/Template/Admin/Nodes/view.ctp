<?php $this->Breadcrumbs->add(__('Menu Items'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($node->title); ?>
<?= $this->Toolbar->addLink(
    __('Edit {0}', __('Menu Item')),
    ['action' => 'edit', $node->id],
    ['data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addLink(
    __('Delete {0}', __('Menu Item')),
    ['action' => 'delete', $node->id],
    ['data-icon' => 'trash', 'confirm' => __('Are you sure you want to delete # {0}?', $node->id)]) ?>

<?= $this->Toolbar->addLink(
    __('List {0}', __('Menu Items')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu Item')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->startGroup(__('More')); ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menus')),
    ['controller' => 'Menus', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu')),
    ['controller' => 'Menus', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Parent Menu Items')),
    ['controller' => 'Nodes', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Parent Menu Item')),
    ['controller' => 'Nodes', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->endGroup(); ?>
<div class="nodes view">
    <h2 class="ui header">
        <?= h($node->title) ?>
    </h2>

    <?php
    echo $this->cell('Backend.EntityView', [ $node ], [
        'title' => $node->title,
        'model' => 'Content.Nodes',
    ]);
    ?>

<!--
    <table class="ui attached celled striped table">


        <tr>
            <td><?= __('Menu') ?></td>
            <td><?= $node->has('menu') ? $this->Html->link($node->menu->title, ['controller' => 'Menus', 'action' => 'view', $node->menu->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Parent Menu Item') ?></td>
            <td><?= $node->has('parent_node') ? $this->Html->link($node->parent_node->title, ['controller' => 'Nodes', 'action' => 'view', $node->parent_node->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Title') ?></td>
            <td><?= h($node->title) ?></td>
        </tr>
        <tr>
            <td><?= __('Type') ?></td>
            <td><?= h($node->type) ?></td>
        </tr>
        <tr>
            <td><?= __('Typeid') ?></td>
            <td><?= h($node->typeid) ?></td>
        </tr>
        <tr>
            <td><?= __('Link Target') ?></td>
            <td><?= h($node->link_target) ?></td>
        </tr>
        <tr>
            <td><?= __('Cssid') ?></td>
            <td><?= h($node->cssid) ?></td>
        </tr>
        <tr>
            <td><?= __('Cssclass') ?></td>
            <td><?= h($node->cssclass) ?></td>
        </tr>


        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($node->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Lft') ?></td>
            <td><?= $this->Number->format($node->lft) ?></td>
        </tr>
        <tr>
            <td><?= __('Rght') ?></td>
            <td><?= $this->Number->format($node->rght) ?></td>
        </tr>
        <tr>
            <td><?= __('Level') ?></td>
            <td><?= $this->Number->format($node->level) ?></td>
        </tr>


        <tr class="date">
            <td><?= __('Created') ?></td>
            <td><?= h($node->created) ?></td>
        </tr>
        <tr class="date">
            <td><?= __('Modified') ?></td>
            <td><?= h($node->modified) ?></td>
        </tr>

        <tr class="boolean">
            <td><?= __('Hide In Nav') ?></td>
            <td><?= $node->hide_in_nav ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr class="boolean">
            <td><?= __('Hide In Sitemap') ?></td>
            <td><?= $node->hide_in_sitemap ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr class="text">
            <td><?= __('Type Params') ?></td>
            <td><?= $this->Text->autoParagraph(h($node->type_params)); ?></td>
        </tr>
        <tr class="text">
            <td><?= __('Url') ?></td>
            <td><?= $this->Text->autoParagraph(h($node->url)); ?></td>
        </tr>
    </table>
</div>
-->
<div class="related">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __('Related {0}', __('Nodes')) ?></h4>
    <?php if (!empty($node->child_nodes)): ?>
    <table class="ui table">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Menu Id') ?></th>
            <th><?= __('Lft') ?></th>
            <th><?= __('Rght') ?></th>
            <th><?= __('Level') ?></th>
            <th><?= __('Parent Id') ?></th>
            <th><?= __('Title') ?></th>
            <th><?= __('Type') ?></th>
            <th><?= __('Typeid') ?></th>
            <th><?= __('Type Params') ?></th>
            <th><?= __('Url') ?></th>
            <th><?= __('Link Target') ?></th>
            <th><?= __('Cssid') ?></th>
            <th><?= __('Cssclass') ?></th>
            <th><?= __('Hide In Nav') ?></th>
            <th><?= __('Hide In Sitemap') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($node->child_nodes as $childNodes): ?>
        <tr>
            <td><?= h($childNodes->id) ?></td>
            <td><?= h($childNodes->site_id) ?></td>
            <td><?= h($childNodes->lft) ?></td>
            <td><?= h($childNodes->rght) ?></td>
            <td><?= h($childNodes->level) ?></td>
            <td><?= h($childNodes->parent_id) ?></td>
            <td><?= h($childNodes->title) ?></td>
            <td><?= h($childNodes->type) ?></td>
            <td><?= h($childNodes->typeid) ?></td>
            <td><?= h($childNodes->type_params) ?></td>
            <td><?= h($childNodes->url) ?></td>
            <td><?= h($childNodes->link_target) ?></td>
            <td><?= h($childNodes->cssid) ?></td>
            <td><?= h($childNodes->cssclass) ?></td>
            <td><?= h($childNodes->hide_in_nav) ?></td>
            <td><?= h($childNodes->hide_in_sitemap) ?></td>
            <td><?= h($childNodes->created) ?></td>
            <td><?= h($childNodes->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Nodes', 'action' => 'view', $childNodes->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Nodes', 'action' => 'edit', $childNodes->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Nodes', 'action' => 'delete', $childNodes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childNodes->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>



