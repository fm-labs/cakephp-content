<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Gallery'))); ?>
<?php $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $gallery->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $gallery->id)]
)
?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Galleries')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->assign('title', $gallery->title); ?>
<div class="form">
    <?= $this->Form->create($gallery, ['url' => ['action' => 'edit', $gallery->id]]); ?>
        <?php
        echo $this->Form->control('parent_id', ['empty' => true]);
        echo $this->Form->control('title');
        echo $this->Form->control('inherit_desc');
        echo $this->Form->control('desc_html', [
            'type' => 'htmleditor',
            'editor' => [
                'image_list_url' => '@Content.HtmlEditor.default.imageList',
                'link_list_url' => '@Content.HtmlEditor.default.linkList'
            ]
        ]);
        echo $this->Form->control('view_template');
        echo $this->Form->control('source', ['empty' => true]);
        echo $this->Form->control('source_folder', ['empty' => true]);
        ?>
    <?= $this->Form->button(__d('content','Submit')) ?>
    <?= $this->Form->end() ?>

</div>
