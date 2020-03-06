<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','New {0}', __d('content','Gallery'))); ?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Galleries')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->startGroup('More'); ?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Posts')),
    ['controller' => 'Posts', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>

<?php $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Post')),
    ['controller' => 'Posts', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->endGroup(); ?>
<?php $this->set('title', __d('content','Add {0}', __d('content','Gallery'))); ?>
<div class="form">
    <h2 class="ui header">
        <?= __d('content','Add {0}', __d('content','Gallery')) ?>
    </h2>
    <?= $this->Form->create($gallery, ['class' => 'no-ajax']); ?>
    <div class="ui form">
        <?php
        echo $this->Form->control('parent_id', ['empty' => true]);
        echo $this->Form->control('title', ['placeholder' => 'Slider']);
        echo $this->Form->control('inherit_desc', ['label' => __d('content', 'Inherit description from parent gallery')]);
        echo $this->Form->control('desc_html', [
            'type' => 'htmleditor',
            'editor' => 'content'
        ]);
        echo $this->Form->control('view_template');
        echo $this->Form->control('source');
        echo $this->Form->control('source_folder');


        echo $this->Form->control('_generate_slider', ['type' => 'checkbox', 'label' => __d('content', 'Automatically generate slider module')]);
        ?>
    </div>
    <?= $this->Form->button(__d('content','Submit')) ?>
    <?= $this->Form->end() ?>

</div>