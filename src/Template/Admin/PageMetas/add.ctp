<?php $this->Breadcrumbs->add(__d('content', 'Page Metas'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content', 'New {0}', __d('content', 'Page Meta'))); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Page Metas')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="form">
    <h2 class="ui header">
        <?= __d('content', 'Add {0}', __d('content', 'Page Meta')) ?>
    </h2>
    <?= $this->Form->create($pageMeta); ?>
    <div class="users ui basic segment">
        <div class="ui form">
        <?php
        echo $this->Form->input('model');
        echo $this->Form->input('foreignKey');
        echo $this->Form->input('title');
        echo $this->Form->input('description');
        echo $this->Form->input('keywords');
        echo $this->Form->input('robots', ['options' => $robots, 'empty' => __d('content', '-- Select --')]);
        echo $this->Form->input('lang');
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content', 'Submit')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>