<?php $this->Breadcrumbs->add(__d('content', 'Categories'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($category->name); ?>
<?php $this->loadHelper('Backend.Toolbar'); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'Edit {0}', __d('content', 'Category')),
    ['action' => 'edit', $category->id],
    ['data-icon' => 'edit']
) ?>
<?php $this->Toolbar->addLink(
    __d('content', 'Delete {0}', __d('content', 'Category')),
    ['action' => 'delete', $category->id],
    ['data-icon' => 'trash', 'confirm' => __d('content', 'Are you sure you want to delete # {0}?', $category->id)]) ?>

<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Categories')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __d('content', 'New {0}', __d('content', 'Category')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->startGroup(__d('content', 'More')); ?>
<?php $this->Toolbar->addLink(
    __d('content', 'List {0}', __d('content', 'Articles')),
    ['controller' => 'Articles', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __d('content', 'New {0}', __d('content', 'Article')),
    ['controller' => 'Articles', 'action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->endGroup(); ?>
<div class="categories view">
    <h2 class="ui header">
        <?= h($category->name) ?>
    </h2>

    <?php
    echo $this->cell('Backend.EntityView', [ $category ], [
        'title' => $category->title,
        'model' => 'Content.Categories',
    ]);
    ?>

<!--
    <table class="ui attached celled striped table">


        <tr>
            <td><?= __d('content', 'Name') ?></td>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <td><?= __d('content', 'Slug') ?></td>
            <td><?= h($category->slug) ?></td>
        </tr>


        <tr>
            <td><?= __d('content', 'Id') ?></td>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>

        <tr class="boolean">
            <td><?= __d('content', 'Is Published') ?></td>
            <td><?= $category->is_published ? __d('content', 'Yes') : __d('content', 'No'); ?></td>
        </tr>
    </table>
</div>
-->
<div class="related" style="overflow-x: scroll;">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __d('content', 'Related {0}', __d('content', 'Articles')) ?></h4>
    <?php if (!empty($category->posts)): ?>
    <table class="ui table">
        <tr>
            <th><?= __d('content', 'Id') ?></th>
            <th><?= __d('content', 'Site Id') ?></th>
            <th><?= __d('content', 'Refscope') ?></th>
            <th><?= __d('content', 'Refid') ?></th>
            <th><?= __d('content', 'Parent Id') ?></th>
            <th><?= __d('content', 'Type') ?></th>
            <th><?= __d('content', 'Type Params') ?></th>
            <th><?= __d('content', 'Title') ?></th>
            <th><?= __d('content', 'Slug') ?></th>
            <th><?= __d('content', 'Subheading') ?></th>
            <th><?= __d('content', 'Use Teaser') ?></th>
            <th><?= __d('content', 'Teaser Html') ?></th>
            <th><?= __d('content', 'Teaser Link Href') ?></th>
            <th><?= __d('content', 'Teaser Link Caption') ?></th>
            <th><?= __d('content', 'Teaser Image File') ?></th>
            <th><?= __d('content', 'Teaser Template') ?></th>
            <th><?= __d('content', 'Body Html') ?></th>
            <th><?= __d('content', 'Image Link Href') ?></th>
            <th><?= __d('content', 'Image Link Target') ?></th>
            <th><?= __d('content', 'Image Desc') ?></th>
            <th><?= __d('content', 'Template') ?></th>
            <th><?= __d('content', 'Cssclass') ?></th>
            <th><?= __d('content', 'Cssid') ?></th>
            <th><?= __d('content', 'Is Published') ?></th>
            <th><?= __d('content', 'Publish Start Datetime') ?></th>
            <th><?= __d('content', 'Publish End Datetime') ?></th>
            <th><?= __d('content', 'Pos') ?></th>
            <th><?= __d('content', 'Section') ?></th>
            <th><?= __d('content', 'Is Home') ?></th>
            <th><?= __d('content', 'Is Archived') ?></th>
            <th><?= __d('content', 'Modified') ?></th>
            <th><?= __d('content', 'Created') ?></th>
            <th class="actions"><?= __d('content', 'Actions') ?></th>
        </tr>
        <?php foreach ($category->posts as $articles): ?>
        <tr>
            <td><?= h($articles->id) ?></td>
            <td><?= h($articles->site_id) ?></td>
            <td><?= h($articles->refscope) ?></td>
            <td><?= h($articles->refid) ?></td>
            <td><?= h($articles->parent_id) ?></td>
            <td><?= h($articles->type) ?></td>
            <td><?= h($articles->type_params) ?></td>
            <td><?= h($articles->title) ?></td>
            <td><?= h($articles->slug) ?></td>
            <td><?= h($articles->subheading) ?></td>
            <td><?= h($articles->use_teaser) ?></td>
            <td><?= h(\Cake\Utility\Text::truncate($articles->teaser_html)) ?></td>
            <td><?= h($articles->teaser_link_href) ?></td>
            <td><?= h($articles->teaser_link_caption) ?></td>
            <td><?= h($articles->teaser_image_file) ?></td>
            <td><?= h($articles->teaser_template) ?></td>
            <td><?= h(\Cake\Utility\Text::truncate($articles->body_html)) ?></td>
            <td><?= h($articles->image_link_href) ?></td>
            <td><?= h($articles->image_link_target) ?></td>
            <td><?= h($articles->image_desc) ?></td>
            <td><?= h($articles->template) ?></td>
            <td><?= h($articles->cssclass) ?></td>
            <td><?= h($articles->cssid) ?></td>
            <td><?= h($articles->is_published) ?></td>
            <td><?= h($articles->publish_start_datetime) ?></td>
            <td><?= h($articles->publish_end_datetime) ?></td>
            <td><?= h($articles->pos) ?></td>
            <td><?= h($articles->section) ?></td>
            <td><?= h($articles->is_home) ?></td>
            <td><?= h($articles->is_archived) ?></td>
            <td><?= h($articles->modified) ?></td>
            <td><?= h($articles->created) ?></td>

            <td class="actions">
                <?= $this->Html->link(__d('content', 'View'), ['controller' => 'Articles', 'action' => 'view', $articles->id]) ?>

                <?= $this->Html->link(__d('content', 'Edit'), ['controller' => 'Articles', 'action' => 'edit', $articles->id]) ?>

                <?= $this->Form->postLink(__d('content', 'Delete'), ['controller' => 'Articles', 'action' => 'delete', $articles->id], ['confirm' => __d('content', 'Are you sure you want to delete # {0}?', $articles->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>



