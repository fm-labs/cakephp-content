<?php $this->Breadcrumbs->add(__d('content', 'Categories'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content', 'Edit {0}', __d('content', 'Category'))); ?>
<?php $this->Toolbar->addPostLink(
    __d('content', 'Delete'),
    ['action' => 'delete', $category->id],
    ['data-icon' => 'trash', 'confirm' => __d('content', 'Are you sure you want to delete # {0}?', $category->id)]
)
?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Categories')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Posts')),
    ['controller' => 'Posts', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>

<?php $this->Toolbar->addLink(
    __d('content', 'New {0}', __d('content', 'Post')),
    ['controller' => 'Posts', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __d('content', 'Edit {0}', __d('content', 'Category')) ?>
    </h2>
    <?= $this->Form->create($category, ['class' => 'no-ajax']); ?>
        <div class="ui form">
        <?php
                echo $this->Form->input('name');
                echo $this->Form->input('slug');
                echo $this->Form->input('is_published');
        ?>
        </div>

    <?= $this->Form->button(__d('content', 'Submit')) ?>
    <?= $this->Form->end() ?>

</div>