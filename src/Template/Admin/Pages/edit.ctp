<?php
$this->loadHelper('Media.Media');
$this->loadHelper('Bootstrap.Tabs');

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $post->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addLink([
    'title' => __d('content','List {0}', __d('content','Pages')),
    'url' => ['action' => 'index'],
    'attr' => ['data-icon' => 'list']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $post->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $post->id)],
]);
?>
<?php
// Breadcrumbs
$this->Breadcrumbs->add(__('Pages'), ['action' => 'index']);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Page')));
// Heading
$this->assign('title', $post->title);
$this->assign('heading', $post->title);

if ($post->parent_id):
    $this->assign('heading', $this->Html->link($post->parent->title, ['action' => 'edit', $post->parent->id, 'type' => $post->parent->type]));
    $this->assign('subheading', $post->title);
endif;
?>

<?php $this->Tabs->create(); ?>
<?php $this->Tabs->add(__('Edit')); ?>

    <?= $this->Form->create($post); ?>
    <div class="row">
        <div class="col-md-9">
            <?php
            echo $this->Form->hidden('type');
            echo $this->Form->input('title');
            echo $this->Form->input('slug');
            //echo $this->Form->input('subheading');
            ?>

            <!-- Teaser
            <?= $this->Form->fieldsetStart(['legend' => 'Teaser', 'collapsed' => !($post->use_teaser || $post->teaser_html)]);  ?>
            <?php
                    echo $this->Form->input('use_teaser');
                    echo $this->Form->input('teaser_html', [
                        'type' => 'htmleditor',
                        'editor' => $editor
                    ]);
                    echo $this->Form->input('teaser_link_caption');
                    echo $this->Form->input('teaser_link_href');
                    echo $this->Form->input('teaser_template', ['empty' => '- Default -']);
                    echo $this->Form->input('teaser_image_file', ['type' => 'media_picker']);
                    ?>
            <?= $this->Form->fieldsetEnd(); ?>
            -->
            <!-- Content -->
            <?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
            <?php
            echo $this->Form->input('body_html', [
                'type' => 'htmleditor',
                'editor' => $editor
            ]);
            ?>
            <?= $this->Form->fieldsetEnd(); ?>


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

            <?= $this->Form->fieldsetStart(['legend' => 'Meta', 'collapsed' => false]); ?>

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

<!-- Debug -->
<?php $this->Tabs->add(__('Debug'), ['debugOnly' => true]); ?>
<?= $this->cell('Backend.EntityView', [$post], ['model' => 'Content.Posts']); ?>
<?php debug($post); ?>

<?php echo $this->Tabs->render(); ?>
<script>
    <?php
    $mediapicker = [
        'modal' => true,
        'treeUrl' => $this->Url->build(['plugin' => 'Media', 'controller' => 'MediaManager', 'action' => 'treeData', 'config' => 'images', '_ext' => 'json']),
        'filesUrl' => $this->Url->build(['plugin' => 'Media', 'controller' => 'MediaManager', 'action' => 'filesData', 'config' => 'images', '_ext' => 'json'])
    ];
    ?>
    $(document).ready(function() {
        $('.media-picker').mediapicker(<?= json_encode($mediapicker); ?>);
    });
</script>
<?php debug($post); ?>