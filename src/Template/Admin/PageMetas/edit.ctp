<?php $this->Breadcrumbs->add(__d('content', 'Page Metas'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content', 'Edit {0}', __d('content', 'Page Meta'))); ?>
<?php $this->Toolbar->addPostLink(
    __d('content', 'Delete'),
    ['action' => 'delete', $pageMeta->id],
    ['data-icon' => 'trash', 'confirm' => __d('content', 'Are you sure you want to delete # {0}?', $pageMeta->id)]
)
?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Page Metas')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __d('content', 'Edit {0}', __d('content', 'Page Meta')) ?>
    </h2>
    <?= $this->Form->create($pageMeta); ?>
    <div class="users ui basic segment">
        <div class="ui form">
        <?php
                echo $this->Form->hidden('model');
                echo $this->Form->hidden('foreignKey');
                echo $this->Form->control('title');
                echo $this->Form->control('description');
                echo $this->Form->control('keywords');
                echo $this->Form->control('robots', ['options' => $robots, 'empty' => __d('content', '-- Select --')]);
                echo $this->Form->control('lang');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content', 'Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>