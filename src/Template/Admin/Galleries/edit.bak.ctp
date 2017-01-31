<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Gallery'))); ?>
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
<?php $this->assign('title', $gallery->title); ?>
<div class="form">
    <?= $this->Form->create($gallery, ['url' => ['action' => 'edit', $gallery->id]]); ?>
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
    <?= $this->Form->button(__d('content','Submit')) ?>
    <?= $this->Form->end() ?>

</div>
