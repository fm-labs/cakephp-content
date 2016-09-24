<?php $this->loadHelper('Bootstrap.Tabs'); ?>
<?php $this->Html->addCrumb(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','Edit {0}', __d('content','Gallery'))); ?>
<?= $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $gallery->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $gallery->id)]
)
?>
<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Galleries')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>


<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-image"></i>
        <strong><?= __d('content', 'Edit {0}', __d('content', 'Gallery')); ?></strong>
        <?= h($gallery->title); ?>
    </div>
    <div class="panel-body">

        <div class="form">
            <?= $this->Form->create($gallery, ['class' => 'no-ajax']); ?>
            <div class="ui form">
                <?php
                echo $this->Form->input('parent_id', ['empty' => true]);
                echo $this->Form->input('title');
                echo $this->Form->input('inherit_desc');
                echo $this->Form->input('desc_html', [
                    'type' => 'htmleditor',
                    'editor' => [
                        'image_list_url' => '@Content.HtmlEditor.default.imageList',
                        'link_list_url' => '@Content.HtmlEditor.default.linkList'
                    ]
                ]);
                echo $this->Form->input('view_template');
                echo $this->Form->input('source', ['empty' => true]);
                echo $this->Form->input('source_folder', ['empty' => true]);
                ?>
            </div>
            <?= $this->Form->button(__d('content','Submit')) ?>
            <?= $this->Form->end() ?>

        </div>

    </div>
</div>

