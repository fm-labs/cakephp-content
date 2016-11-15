<?php $this->Html->addCrumb(__('Menus'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__('New {0}', __('Menu'))); ?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Menus')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
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
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __('Add {0}', __('Menu')) ?>
    </h2>
    <?= $this->Form->create($menu, ['class' => 'no-ajax']); ?>
        <div class="ui form">
        <?php
                echo $this->Form->input('title');
        ?>
        </div>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>