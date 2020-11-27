<?php $this->Breadcrumbs->add(__d('content', 'Categories'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content', 'New {0}', __d('content', 'Category'))); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Categories')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Pages')),
    ['controller' => 'Pages', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>

<?php $this->Toolbar->addLink(
    __d('content', 'New {0}', __d('content', 'Page')),
    ['controller' => 'Pages', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __d('content', 'Add {0}', __d('content', 'Category')) ?>
    </h2>
    <?= $this->Form->create($category, ['class' => 'no-ajax']); ?>
        <div class="ui form">
        <?php
                echo $this->Form->control('name');
                echo $this->Form->control('slug');
                echo $this->Form->control('is_published');
        ?>
        </div>

    <?= $this->Form->button(__d('content', 'Submit')) ?>
    <?= $this->Form->end() ?>

</div>