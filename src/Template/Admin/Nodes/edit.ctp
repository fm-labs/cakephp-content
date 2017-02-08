<?php $this->Breadcrumbs->add(__('Nodes'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__('Edit {0}', __('Node'))); ?>
<?= $this->Toolbar->addPostLink(
    __('Delete'),
    ['action' => 'delete', $node->id],
    ['data-icon' => 'trash', 'confirm' => __('Are you sure you want to delete # {0}?', $node->id)]
)
?>
<?= $this->Toolbar->addLink(
    __('List {0}', __('Nodes')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<div class="form">
    <h2 class="ui header">
        <?= __('Edit {0}', __('Node')) ?>
    </h2>
    <?= $this->Form->create($node, ['class' => 'no-ajax']); ?>
        <div class="ui form">
        <?php
            echo $this->Form->input('site_id', ['type' => 'text']);
            echo $this->Form->input('parent_id', ['options' => $parentNodes, 'empty' => true]);
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
        </div>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>