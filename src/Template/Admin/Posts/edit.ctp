<?php
$this->loadHelper('Bootstrap.Tabs');
$this->loadHelper('Media.MediaPicker');

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $post->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $post->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $post->id)],
]);
?>
<?php
// Breadcrumbs
$this->Breadcrumbs->add(__('Posts'), ['action' => 'index']);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Post')));

// Heading
$this->assign('title', $post->title);
$this->assign('heading', $post->title);

if ($post->parent_id):
    $this->assign('heading', $this->Html->link($post->parent->title, ['action' => 'edit', $post->parent->id, 'type' => $post->parent->type]));
    $this->assign('subheading', $post->title);
endif;
?>
<div class="posts edit">
    <?php $this->Tabs->create(); ?>
    <?php $this->Tabs->add(__('Edit')); ?>

    <?= $this->Form->create($post, ['horizontal' => true]); ?>
    <?php
    echo $this->Form->hidden('type');
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    //echo $this->Form->input('subheading');
    ?>
    <?php
    echo $this->Form->input('use_teaser');
    ?>

    <?= $this->Form->fieldsetStart(['legend' => 'Teaser', 'collapsed' => !($post->use_teaser || $post->teaser_html)]);  ?>
    <!-- Teaser -->
    <?php
    echo $this->Form->input('teaser_html', [
        'type' => 'htmleditor',
        'editor' => $editor
    ]);
    ?>
    <?php
    //echo $this->Form->input('teaser_link_caption');
    //echo $this->Form->input('teaser_link_href');
    //echo $this->Form->input('teaser_image_file', ['type' => 'media_picker']);
    echo $this->Form->input('teaser_template', ['empty' => '- Default -']);
    ?>
    <?= $this->Form->fieldsetEnd(); ?>

    <!-- Content -->
    <?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
    <?php
    echo $this->Form->input('body_html', [
        'type' => 'htmleditor',
        'editor' => $editor
    ]);
    ?>

    <?php
    echo $this->Form->input('template', ['empty' => '- Default -']);
    ?>
    <?= $this->Form->fieldsetEnd(); ?>

    <!-- Media / Images -->
    <?= $this->Form->fieldsetStart(['legend' => 'Images', 'collapsed' => false]);  ?>

    <?= $this->Form->input('teaser_image_file', ['type' => 'media_picker', 'config' => 'images']); ?>
    <?= $this->Form->input('image_file', ['type' => 'media_picker', 'config' => 'images']); ?>


    <?php /* $this->cell('Media.ImageSelect', [[
        'label' => 'Additional Images',
        'model' => 'Content.Posts',
        'id' => $post->id,
        'scope' => 'image_files',
        'multiple' => true,
        'image' => $post->image_files,
        'imageOptions' => ['width' => 200]
    ]]); */ ?>
    <?= $this->Form->fieldsetEnd(); ?>


    <!-- Publish -->
    <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
    <?php
    echo $this->Form->input('is_published');
    echo $this->Form->input('publish_start_date', ['type' => 'datepicker']);
    echo $this->Form->input('publish_end_date', ['type' => 'datepicker']);
    ?>
    <?= $this->Form->fieldsetEnd(); ?>

    <!-- Submit -->
    <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

    <!-- Advanced -->
    <?php $this->Tabs->add(__('Advanced')); ?>
    <?= $this->Form->create($post, ['horizontal' => true]); ?>
    <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => false]); ?>
    <?php
    echo $this->Form->input('refscope');
    echo $this->Form->input('refid');
    echo $this->Form->input('cssclass');
    echo $this->Form->input('cssid');
    echo $this->Form->input('order');
    ?>
    <?= $this->Form->fieldsetEnd(); ?>

    <!-- Submit -->
    <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

    <!-- Related Posts -->
    <?php $this->Tabs->add(__('Subposts')); ?>
    <?php if (!$post->parent_id): ?>
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
                    //'type',
                    //'parent_id',
                    'title' => [
                        'formatter' => function($val, $row) {
                            return $this->Html->link($val, ['action' => 'edit', $row->id]);
                        }
                    ],
                    'is_published'
                ],
                'rowActions' => [
                    [__d('shop','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
                    [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
                ]
            ]]);
            ?>

            <?= $this->Html->link(__('Add post'), ['action' => 'add', 'parent_id' => $post->id], ['class' => 'btn btn-primary']); ?>
        </div>
        <?= $this->Form->fieldsetEnd(); ?>
    <?php endif; ?>

    <!-- Meta -->
    <?php $this->Tabs->add(__('Meta')); ?>

    <?= $this->Form->create($post); ?>
    <?= $this->Form->fieldsetStart(['legend' => 'Meta', 'collapsed' => false]); ?>

    <?= $this->Form->input('meta_title'); ?>
    <?= $this->Form->input('meta_desc'); ?>
    <?= $this->Form->input('meta_keywords'); ?>
    <?= $this->Form->input('meta_lang'); ?>
    <?= $this->Form->input('meta_robots'); ?>

    <?= $this->Form->fieldsetEnd(); ?>
    <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary btn-block']) ?>
    <?= $this->Form->end() ?>

    <!-- Debug -->
    <?php $this->Tabs->add(__('Debug'), ['debugOnly' => true]); ?>
    <?= $this->cell('Backend.EntityView', [$post], ['model' => 'Content.Posts']); ?>
    <?php debug($post); ?>

    <?php echo $this->Tabs->render(); ?>

</div>