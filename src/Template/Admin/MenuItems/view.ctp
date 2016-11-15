<?php $this->Html->addCrumb(__('Menu Items'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb($menuItem->title); ?>
<?= $this->Toolbar->addLink(
    __('Edit {0}', __('Menu Item')),
    ['action' => 'edit', $menuItem->id],
    ['data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addLink(
    __('Delete {0}', __('Menu Item')),
    ['action' => 'delete', $menuItem->id],
    ['data-icon' => 'trash', 'confirm' => __('Are you sure you want to delete # {0}?', $menuItem->id)]) ?>

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
    ['controller' => 'MenuItems', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Parent Menu Item')),
    ['controller' => 'MenuItems', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->endGroup(); ?>
<div class="menuItems view">
    <h2 class="ui header">
        <?= h($menuItem->title) ?>
    </h2>

    <?php
    echo $this->cell('Backend.EntityView', [ $post ], [
        'title' => $post->title,
        'model' => 'Content.MenuItems',
    ]);
    ?>

<!--
    <table class="ui attached celled striped table">


        <tr>
            <td><?= __('Menu') ?></td>
            <td><?= $menuItem->has('menu') ? $this->Html->link($menuItem->menu->title, ['controller' => 'Menus', 'action' => 'view', $menuItem->menu->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Parent Menu Item') ?></td>
            <td><?= $menuItem->has('parent_menu_item') ? $this->Html->link($menuItem->parent_menu_item->title, ['controller' => 'MenuItems', 'action' => 'view', $menuItem->parent_menu_item->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Title') ?></td>
            <td><?= h($menuItem->title) ?></td>
        </tr>
        <tr>
            <td><?= __('Type') ?></td>
            <td><?= h($menuItem->type) ?></td>
        </tr>
        <tr>
            <td><?= __('Typeid') ?></td>
            <td><?= h($menuItem->typeid) ?></td>
        </tr>
        <tr>
            <td><?= __('Link Target') ?></td>
            <td><?= h($menuItem->link_target) ?></td>
        </tr>
        <tr>
            <td><?= __('Cssid') ?></td>
            <td><?= h($menuItem->cssid) ?></td>
        </tr>
        <tr>
            <td><?= __('Cssclass') ?></td>
            <td><?= h($menuItem->cssclass) ?></td>
        </tr>


        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($menuItem->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Lft') ?></td>
            <td><?= $this->Number->format($menuItem->lft) ?></td>
        </tr>
        <tr>
            <td><?= __('Rght') ?></td>
            <td><?= $this->Number->format($menuItem->rght) ?></td>
        </tr>
        <tr>
            <td><?= __('Level') ?></td>
            <td><?= $this->Number->format($menuItem->level) ?></td>
        </tr>


        <tr class="date">
            <td><?= __('Created') ?></td>
            <td><?= h($menuItem->created) ?></td>
        </tr>
        <tr class="date">
            <td><?= __('Modified') ?></td>
            <td><?= h($menuItem->modified) ?></td>
        </tr>

        <tr class="boolean">
            <td><?= __('Hide In Nav') ?></td>
            <td><?= $menuItem->hide_in_nav ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr class="boolean">
            <td><?= __('Hide In Sitemap') ?></td>
            <td><?= $menuItem->hide_in_sitemap ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr class="text">
            <td><?= __('Type Params') ?></td>
            <td><?= $this->Text->autoParagraph(h($menuItem->type_params)); ?></td>
        </tr>
        <tr class="text">
            <td><?= __('Url') ?></td>
            <td><?= $this->Text->autoParagraph(h($menuItem->url)); ?></td>
        </tr>
    </table>
</div>
-->
<div class="related">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __('Related {0}', __('MenuItems')) ?></h4>
    <?php if (!empty($menuItem->child_menu_items)): ?>
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
        <?php foreach ($menuItem->child_menu_items as $childMenuItems): ?>
        <tr>
            <td><?= h($childMenuItems->id) ?></td>
            <td><?= h($childMenuItems->menu_id) ?></td>
            <td><?= h($childMenuItems->lft) ?></td>
            <td><?= h($childMenuItems->rght) ?></td>
            <td><?= h($childMenuItems->level) ?></td>
            <td><?= h($childMenuItems->parent_id) ?></td>
            <td><?= h($childMenuItems->title) ?></td>
            <td><?= h($childMenuItems->type) ?></td>
            <td><?= h($childMenuItems->typeid) ?></td>
            <td><?= h($childMenuItems->type_params) ?></td>
            <td><?= h($childMenuItems->url) ?></td>
            <td><?= h($childMenuItems->link_target) ?></td>
            <td><?= h($childMenuItems->cssid) ?></td>
            <td><?= h($childMenuItems->cssclass) ?></td>
            <td><?= h($childMenuItems->hide_in_nav) ?></td>
            <td><?= h($childMenuItems->hide_in_sitemap) ?></td>
            <td><?= h($childMenuItems->created) ?></td>
            <td><?= h($childMenuItems->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'MenuItems', 'action' => 'view', $childMenuItems->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'MenuItems', 'action' => 'edit', $childMenuItems->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'MenuItems', 'action' => 'delete', $childMenuItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childMenuItems->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>



