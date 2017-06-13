<?php
$this->loadHelper('Backend.Box');
$this->loadHelper('Backend.DataTable');
$this->loadHelper('Bootstrap.Tabs');

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $post->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addLink([
    'title' => __d('content','List {0}', __d('content','Posts')),
    'url' => ['action' => 'index'],
    'attr' => ['data-icon' => 'list']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $post->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $post->id)],
]);

?>
<?= $this->Form->create($post); ?>
<div class="clearfix clear-fix" style="clear: both;"></div>
<div class="row">
    <div class="col-md-9">
        <?php
        echo $this->Form->hidden('type');
        echo $this->Form->input('title');
        echo $this->Form->input('slug');
        //echo $this->Form->input('subheading');
        ?>

        <!--
        <?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => true]);  ?>
        <?php
        echo $this->Form->input('body_html', [
            'type' => 'htmleditor',
            'editor' => $editor
        ]);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>
        -->

        <?= $this->Form->fieldsetStart(['legend' => 'Posts', 'collapsed' => false]);  ?>
        <div class="child-posts">

            <?= $this->cell('Backend.DataTable', [[
                'paginate' => false,
                'sortable' => true,
                'model' => 'Content.Posts',
                'data' => $post->children,
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

            <?= $this->Html->link(__d('content', 'Add post'), ['action' => 'add', 'parent_id' => $post->id], ['class' => 'btn btn-primary']); ?>
        </div>
        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->fieldsetStart(['legend' => 'Meta', 'collapsed' => true]); ?>

        <?= $this->Form->input('meta_title'); ?>
        <?= $this->Form->input('meta_desc'); ?>
        <?= $this->Form->input('meta_keywords'); ?>
        <?= $this->Form->input('meta_lang'); ?>
        <?= $this->Form->input('meta_robots'); ?>

        <?= $this->Form->fieldsetEnd(); ?>
    </div>
    <div class="col-md-3">

        <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary btn-block']) ?>

        <!-- Publish -->
        <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
        <?php
        echo $this->Form->input('is_published');
        echo $this->Form->input('publish_start_date', ['type' => 'datepicker']);
        echo $this->Form->input('publish_end_date', ['type' => 'datepicker']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <!-- Layout -->
        <?= $this->Form->fieldsetStart(['legend' => 'Layout', 'collapsed' => false]); ?>
        <?php
        echo $this->Form->input('template', ['empty' => '- Default -']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <!-- Media -->
        <?= $this->Form->fieldsetStart(['legend' => 'Media', 'collapsed' => false]); ?>
        <?= $this->Form->input('image_file', ['type' => 'media_picker']); ?>
        <?= $this->cell('Media.ImageSelect', [[
            'label' => 'Additional Images',
            'model' => 'Content.Posts',
            'id' => $post->id,
            'scope' => 'image_files',
            'multiple' => true,
            'image' => $post->image_files,
            'imageOptions' => ['width' => 200]
        ]]); ?>
        <?= $this->Form->fieldsetEnd(); ?>


        <!-- Advanced -->
        <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => true]); ?>
            <?php
            echo $this->Form->input('refscope');
            echo $this->Form->input('refid');
            echo $this->Form->input('cssclass');
            echo $this->Form->input('cssid');
            echo $this->Form->input('order');
            ?>
        <?= $this->Form->fieldsetEnd(); ?>
    </div>
</div>
<?= $this->Form->end() ?>
<?php debug($post); ?>