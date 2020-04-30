<?php
$this->loadHelper('Admin.Box');
$this->loadHelper('Admin.DataTable');
$this->loadHelper('Bootstrap.Tabs');

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $article->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addLink([
    'title' => __d('content','List {0}', __d('content','Articles')),
    'url' => ['action' => 'index'],
    'attr' => ['data-icon' => 'list']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $article->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $article->id)],
]);

?>
<?= $this->Form->create($article); ?>
<div class="clearfix clear-fix" style="clear: both;"></div>
<div class="row">
    <div class="col-md-9">
        <?php
        echo $this->Form->hidden('type');
        echo $this->Form->control('title');
        echo $this->Form->control('slug');
        //echo $this->Form->control('subheading');
        ?>

        <!--
        <?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => true]);  ?>
        <?php
        echo $this->Form->control('body_html', [
            'type' => 'htmleditor',
            'editor' => $editor
        ]);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>
        -->

        <?= $this->Form->fieldsetStart(['legend' => 'Articles', 'collapsed' => false]);  ?>
        <div class="child-posts">

            <?= $this->cell('Admin.DataTable', [[
                'paginate' => false,
                'sortable' => true,
                'model' => 'Content.Articles',
                'data' => $article->children,
                'fields' => [
                    'id',
                    'created',
                    'pos',
                    'type',
                    'parent_id',
                    'title' => [
                        'formatter' => function($val, $row) {
                            return $this->Html->link($val, ['action' => 'edit', $row->id]);
                        }
                    ],
                    'is_published'
                ],
                'rowActions' => [
                    [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
                    [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
                ]
            ]]);
            ?>

            <?= $this->Html->link(__d('content', 'Add post'), ['action' => 'add', 'parent_id' => $article->id], ['class' => 'btn btn-primary']); ?>
        </div>
        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->fieldsetStart(['legend' => 'Meta', 'collapsed' => true]); ?>

        <?= $this->Form->control('meta_title'); ?>
        <?= $this->Form->control('meta_desc'); ?>
        <?= $this->Form->control('meta_keywords'); ?>
        <?= $this->Form->control('meta_lang'); ?>
        <?= $this->Form->control('meta_robots'); ?>

        <?= $this->Form->fieldsetEnd(); ?>
    </div>
    <div class="col-md-3">

        <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary btn-block']) ?>

        <!-- Publish -->
        <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
        <?php
        echo $this->Form->control('is_published');
        echo $this->Form->control('publish_start_date', ['type' => 'datepicker']);
        echo $this->Form->control('publish_end_date', ['type' => 'datepicker']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <!-- Layout -->
        <?= $this->Form->fieldsetStart(['legend' => 'Layout', 'collapsed' => false]); ?>
        <?php
        echo $this->Form->control('template', ['empty' => '- Default -']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <!-- Media -->
        <?= $this->Form->fieldsetStart(['legend' => 'Media', 'collapsed' => false]); ?>
        <?= $this->Form->control('image_file', ['type' => 'media_picker']); ?>
        <?= $this->cell('Media.ImageSelect', [[
            'label' => 'Additional Images',
            'model' => 'Content.Articles',
            'id' => $article->id,
            'scope' => 'image_files',
            'multiple' => true,
            'image' => $article->image_files,
            'imageOptions' => ['width' => 200]
        ]]); ?>
        <?= $this->Form->fieldsetEnd(); ?>


        <!-- Advanced -->
        <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => true]); ?>
            <?php
            echo $this->Form->control('refscope');
            echo $this->Form->control('refid');
            echo $this->Form->control('cssclass');
            echo $this->Form->control('cssid');
            echo $this->Form->control('order');
            ?>
        <?= $this->Form->fieldsetEnd(); ?>
    </div>
</div>
<?= $this->Form->end() ?>
<?php debug($article); ?>