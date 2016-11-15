<?php $this->Html->addCrumb(__('Menus'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__('Manage {0}', __('Menu'))); ?>

<div class="form">

    <h1>
        <?= __('Manage {0}', __('Menu')) ?>
    </h1>

    <div class="row">
        <div class="col-md-4">
            <h2>
                <?= __('Add {0}', __('Menu Item')) ?>
            </h2>
            <?= $this->Form->create($menuItem, ['class' => '', 'url' => ['controller' => 'MenuItems', 'action' => 'add']]); ?>
            <?php
            echo $this->Form->hidden('menu_id', ['value' => $menu->id]);
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

            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>

        </div>
        <div class="col-md-8">

            <?= $this->Form->create($menu, ['class' => 'no-ajax']); ?>
            <?php echo $this->Form->input('title'); ?>
            <?= $this->Form->button(__('Change title')) ?>
            <?= $this->Form->end() ?>

            <?php echo $this->cell('Content.MenuModule::manage', [ $menu->id ]); ?>
        </div>
    </div>



</div>