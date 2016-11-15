<?php $this->Html->addCrumb(__('Menu Items'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__('Edit {0}', __('Menu Item'))); ?>
<?= $this->Toolbar->addPostLink(
    __('Delete'),
    ['action' => 'delete', $menuItem->id],
    ['data-icon' => 'trash', 'confirm' => __('Are you sure you want to delete # {0}?', $menuItem->id)]
)
?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menu Items')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
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
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __('Edit {0}', __('Menu Item')) ?>
    </h2>
    <?= $this->Form->create($menuItem, ['class' => 'no-ajax']); ?>
        <div class="ui form">
        <?php
                    echo $this->Form->input('menu_id', ['options' => $menus]);
                echo $this->Form->input('lft');
                echo $this->Form->input('rght');
                echo $this->Form->input('level');
                    echo $this->Form->input('parent_id', ['options' => $parentMenuItems, 'empty' => true]);
                echo $this->Form->input('title');
                echo $this->Form->input('type');
                echo $this->Form->input('typeid');
                echo $this->Form->input('type_params');
                echo $this->Form->input('url');
                echo $this->Form->input('link_target');
                echo $this->Form->input('cssid');
                echo $this->Form->input('cssclass');
                echo $this->Form->input('hide_in_nav');
                echo $this->Form->input('hide_in_sitemap');
        ?>
        </div>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>