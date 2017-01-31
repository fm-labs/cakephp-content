<?php $this->Breadcrumbs->add(__('Menus'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($menu->title); ?>
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
    __('List {0}', __('Sites')),
    ['controller' => 'Sites', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Site')),
    ['controller' => 'Sites', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menu Items')),
    ['controller' => 'Nodes', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __('New {0}', __('Menu Item')),
    ['controller' => 'Nodes', 'action' => 'add'],
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
            <td><?= __('Site') ?></td>
            <td><?= $menu->has('site') ? $this->Html->link($menu->site->title, ['controller' => 'Sites', 'action' => 'view', $menu->site->id]) : '' ?></td>
        </tr>
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
    <h4 class="ui header"><?= __('Related {0}', __('Nodes')) ?></h4>
    <?php if (!empty($menu->nodes)): ?>
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
        <?php foreach ($menu->nodes as $nodes): ?>
        <tr>
            <td><?= h($nodes->id) ?></td>
            <td><?= h($nodes->site_id) ?></td>
            <td><?= h($nodes->lft) ?></td>
            <td><?= h($nodes->rght) ?></td>
            <td><?= h($nodes->level) ?></td>
            <td><?= h($nodes->parent_id) ?></td>
            <td><?= h($nodes->title) ?></td>
            <td><?= h($nodes->type) ?></td>
            <td><?= h($nodes->typeid) ?></td>
            <td><?= h($nodes->type_params) ?></td>
            <td><?= h($nodes->url) ?></td>
            <td><?= h($nodes->link_target) ?></td>
            <td><?= h($nodes->cssid) ?></td>
            <td><?= h($nodes->cssclass) ?></td>
            <td><?= h($nodes->hide_in_nav) ?></td>
            <td><?= h($nodes->hide_in_sitemap) ?></td>
            <td><?= h($nodes->created) ?></td>
            <td><?= h($nodes->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Nodes', 'action' => 'view', $nodes->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Nodes', 'action' => 'edit', $nodes->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Nodes', 'action' => 'delete', $nodes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nodes->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __('Related {0}', __('Nodes')) ?></h4>
    <?php if (!empty($menu->root_nodes)): ?>
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
        <?php foreach ($menu->root_nodes as $rootNodes): ?>
        <tr>
            <td><?= h($rootNodes->id) ?></td>
            <td><?= h($rootNodes->site_id) ?></td>
            <td><?= h($rootNodes->lft) ?></td>
            <td><?= h($rootNodes->rght) ?></td>
            <td><?= h($rootNodes->level) ?></td>
            <td><?= h($rootNodes->parent_id) ?></td>
            <td><?= h($rootNodes->title) ?></td>
            <td><?= h($rootNodes->type) ?></td>
            <td><?= h($rootNodes->typeid) ?></td>
            <td><?= h($rootNodes->type_params) ?></td>
            <td><?= h($rootNodes->url) ?></td>
            <td><?= h($rootNodes->link_target) ?></td>
            <td><?= h($rootNodes->cssid) ?></td>
            <td><?= h($rootNodes->cssclass) ?></td>
            <td><?= h($rootNodes->hide_in_nav) ?></td>
            <td><?= h($rootNodes->hide_in_sitemap) ?></td>
            <td><?= h($rootNodes->created) ?></td>
            <td><?= h($rootNodes->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Nodes', 'action' => 'view', $rootNodes->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Nodes', 'action' => 'edit', $rootNodes->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Nodes', 'action' => 'delete', $rootNodes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rootNodes->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>



