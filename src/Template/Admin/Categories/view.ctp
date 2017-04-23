<?php $this->Breadcrumbs->add(__('Categories'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add($category->name); ?>
<?php $this->loadHelper('Backend.Toolbar'); ?>
<?php $this->Toolbar->addLink(
    __('Edit {0}', __('Category')),
    ['action' => 'edit', $category->id],
    ['data-icon' => 'edit']
) ?>
<?php $this->Toolbar->addLink(
    __('Delete {0}', __('Category')),
    ['action' => 'delete', $category->id],
    ['data-icon' => 'trash', 'confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>

<?php $this->Toolbar->addLink(
    __('List {0}', __('Categories')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __('New {0}', __('Category')),
    ['action' => 'add'],
    ['data-icon' => 'plus']
) ?>
<?php $this->Toolbar->startGroup(__('More')); ?>
<?php $this->Toolbar->addLink(
    __('List {0}', __('Posts')),
    ['controller' => 'Posts', 'action' => 'index'],
    ['data-icon' => 'list']
) ?>
<?php $this->Toolbar->addLink(
    __('New {0}', __('Post')),
    ['controller' => 'Posts', 'action' => 'add'],
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
            <td><?= __('Name') ?></td>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <td><?= __('Slug') ?></td>
            <td><?= h($category->slug) ?></td>
        </tr>


        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>

        <tr class="boolean">
            <td><?= __('Is Published') ?></td>
            <td><?= $category->is_published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
-->
<div class="related" style="overflow-x: scroll;">
    <div class="ui basic segment">
    <h4 class="ui header"><?= __('Related {0}', __('Posts')) ?></h4>
    <?php if (!empty($category->posts)): ?>
    <table class="ui table">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Site Id') ?></th>
            <th><?= __('Refscope') ?></th>
            <th><?= __('Refid') ?></th>
            <th><?= __('Parent Id') ?></th>
            <th><?= __('Type') ?></th>
            <th><?= __('Type Params') ?></th>
            <th><?= __('Title') ?></th>
            <th><?= __('Slug') ?></th>
            <th><?= __('Subheading') ?></th>
            <th><?= __('Use Teaser') ?></th>
            <th><?= __('Teaser Html') ?></th>
            <th><?= __('Teaser Link Href') ?></th>
            <th><?= __('Teaser Link Caption') ?></th>
            <th><?= __('Teaser Image File') ?></th>
            <th><?= __('Teaser Template') ?></th>
            <th><?= __('Body Html') ?></th>
            <th><?= __('Image Link Href') ?></th>
            <th><?= __('Image Link Target') ?></th>
            <th><?= __('Image Desc') ?></th>
            <th><?= __('Template') ?></th>
            <th><?= __('Cssclass') ?></th>
            <th><?= __('Cssid') ?></th>
            <th><?= __('Is Published') ?></th>
            <th><?= __('Publish Start Datetime') ?></th>
            <th><?= __('Publish End Datetime') ?></th>
            <th><?= __('Pos') ?></th>
            <th><?= __('Section') ?></th>
            <th><?= __('Is Home') ?></th>
            <th><?= __('Is Archived') ?></th>
            <th><?= __('Modified') ?></th>
            <th><?= __('Created') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($category->posts as $posts): ?>
        <tr>
            <td><?= h($posts->id) ?></td>
            <td><?= h($posts->site_id) ?></td>
            <td><?= h($posts->refscope) ?></td>
            <td><?= h($posts->refid) ?></td>
            <td><?= h($posts->parent_id) ?></td>
            <td><?= h($posts->type) ?></td>
            <td><?= h($posts->type_params) ?></td>
            <td><?= h($posts->title) ?></td>
            <td><?= h($posts->slug) ?></td>
            <td><?= h($posts->subheading) ?></td>
            <td><?= h($posts->use_teaser) ?></td>
            <td><?= h(\Cake\Utility\Text::truncate($posts->teaser_html)) ?></td>
            <td><?= h($posts->teaser_link_href) ?></td>
            <td><?= h($posts->teaser_link_caption) ?></td>
            <td><?= h($posts->teaser_image_file) ?></td>
            <td><?= h($posts->teaser_template) ?></td>
            <td><?= h(\Cake\Utility\Text::truncate($posts->body_html)) ?></td>
            <td><?= h($posts->image_link_href) ?></td>
            <td><?= h($posts->image_link_target) ?></td>
            <td><?= h($posts->image_desc) ?></td>
            <td><?= h($posts->template) ?></td>
            <td><?= h($posts->cssclass) ?></td>
            <td><?= h($posts->cssid) ?></td>
            <td><?= h($posts->is_published) ?></td>
            <td><?= h($posts->publish_start_datetime) ?></td>
            <td><?= h($posts->publish_end_datetime) ?></td>
            <td><?= h($posts->pos) ?></td>
            <td><?= h($posts->section) ?></td>
            <td><?= h($posts->is_home) ?></td>
            <td><?= h($posts->is_archived) ?></td>
            <td><?= h($posts->modified) ?></td>
            <td><?= h($posts->created) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'view', $posts->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $posts->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $posts->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>



