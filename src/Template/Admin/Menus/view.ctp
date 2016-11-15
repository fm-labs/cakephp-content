<?php $this->Html->addCrumb(__('Menus'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb($menu->title); ?>
<?= $this->Toolbar->addLink(
    __('Edit {0}', __('Menu')),
    ['action' => 'edit', $menu->id],
    ['data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addLink(
    __('Delete {0}', __('Menu')),
    ['action' => 'delete', $menu->id],
    ['data-icon' => 'trash', 'confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) ?>

<?= $this->Toolbar->addLink(
    __('List {0}', __('Menus')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->startGroup(__('More')); ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menu Items')),
    ['controller' => 'MenuItems', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu Item')),
    ['controller' => 'MenuItems', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->endGroup(); ?>
<div class="menus view">
    <h2 class="ui header">
        <?= h($menu->title) ?>
    </h2>

    <?php
    echo $this->cell('Backend.EntityView', [ $menu ], [
        'title' => $menu->title,
        'model' => 'Content.Menus',
    ]);
    ?>

<!--
    <table class="ui attached celled striped table">


        <tr>
            <td><?= __('Title') ?></td>
            <td><?= h($menu->title) ?></td>
        </tr>


        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($menu->id) ?></td>
        </tr>

    </table>
</div>
-->
<div class="related">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __('Related {0}', __('MenuItems')) ?></h4>
    <?php if (!empty($menu->menu_items)): ?>
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
        <?php foreach ($menu->menu_items as $menuItems): ?>
        <tr>
            <td><?= h($menuItems->id) ?></td>
            <td><?= h($menuItems->menu_id) ?></td>
            <td><?= h($menuItems->lft) ?></td>
            <td><?= h($menuItems->rght) ?></td>
            <td><?= h($menuItems->level) ?></td>
            <td><?= h($menuItems->parent_id) ?></td>
            <td><?= h($menuItems->title) ?></td>
            <td><?= h($menuItems->type) ?></td>
            <td><?= h($menuItems->typeid) ?></td>
            <td><?= h($menuItems->type_params) ?></td>
            <td><?= h($menuItems->url) ?></td>
            <td><?= h($menuItems->link_target) ?></td>
            <td><?= h($menuItems->cssid) ?></td>
            <td><?= h($menuItems->cssclass) ?></td>
            <td><?= h($menuItems->hide_in_nav) ?></td>
            <td><?= h($menuItems->hide_in_sitemap) ?></td>
            <td><?= h($menuItems->created) ?></td>
            <td><?= h($menuItems->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'MenuItems', 'action' => 'view', $menuItems->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'MenuItems', 'action' => 'edit', $menuItems->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'MenuItems', 'action' => 'delete', $menuItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menuItems->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __('Related {0}', __('MenuItems')) ?></h4>
    <?php if (!empty($menu->root_menu_items)): ?>
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
        <?php foreach ($menu->root_menu_items as $rootMenuItems): ?>
        <tr>
            <td><?= h($rootMenuItems->id) ?></td>
            <td><?= h($rootMenuItems->menu_id) ?></td>
            <td><?= h($rootMenuItems->lft) ?></td>
            <td><?= h($rootMenuItems->rght) ?></td>
            <td><?= h($rootMenuItems->level) ?></td>
            <td><?= h($rootMenuItems->parent_id) ?></td>
            <td><?= h($rootMenuItems->title) ?></td>
            <td><?= h($rootMenuItems->type) ?></td>
            <td><?= h($rootMenuItems->typeid) ?></td>
            <td><?= h($rootMenuItems->type_params) ?></td>
            <td><?= h($rootMenuItems->url) ?></td>
            <td><?= h($rootMenuItems->link_target) ?></td>
            <td><?= h($rootMenuItems->cssid) ?></td>
            <td><?= h($rootMenuItems->cssclass) ?></td>
            <td><?= h($rootMenuItems->hide_in_nav) ?></td>
            <td><?= h($rootMenuItems->hide_in_sitemap) ?></td>
            <td><?= h($rootMenuItems->created) ?></td>
            <td><?= h($rootMenuItems->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'MenuItems', 'action' => 'view', $rootMenuItems->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'MenuItems', 'action' => 'edit', $rootMenuItems->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'MenuItems', 'action' => 'delete', $rootMenuItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rootMenuItems->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>



