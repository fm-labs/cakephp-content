<?php
$this->loadHelper('Bootstrap.Tabs');
//$this->loadHelper('Media.MediaPicker');

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','Preview'),
    'url' => ['action' => 'preview', $article->id],
    'attr' => ['data-icon' => 'eye', 'target' => 'preview']
]);
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $article->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $article->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $article->id)],
]);
?>
<?php
// Breadcrumbs
$this->Breadcrumbs->add(__d('content', 'Articles'), ['action' => 'index']);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Article')));

// Heading
$this->assign('title', $article->title);
$this->assign('heading', $article->title);

if ($article->parent_id):
    $this->assign('heading', $this->Html->link($article->parent->title, ['action' => 'edit', $article->parent->id, 'type' => $article->parent->type]));
    $this->assign('subheading', $article->title);
endif;
?>
<div class="posts edit">
    <?= $this->Form->create($article); ?>
    <?= $this->Form->hidden('type'); ?>
    <div class="row">
        <div class="col-md-9">
            <?php
            echo $this->Form->control('title', ['class' => 'input-block']);
            //echo $this->Form->control('subheading');
            ?>
            <!-- Content -->
            <?php
            echo $this->Form->control('body_html', [
                //'type' => 'htmleditor',
                //'editor' => $editor
            ]);
            ?>
        </div>
        <div class="col-md-3">

            <!-- Submit -->
            <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
            <?= $this->Form->control('slug'); ?>
            <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->fieldsetEnd(); ?>

            <!-- Publish -->
            <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
            <?php
            echo $this->Form->control('is_published', ['type' => 'text']);
            echo $this->Form->control('publish_start_date', ['type' => 'datepicker']);
            echo $this->Form->control('publish_end_date', ['type' => 'datepicker']);
            ?>
            <?= $this->Form->fieldsetEnd(); ?>

            <!-- Template -->
            <?php
            echo $this->Form->control('template', ['empty' => '- Default -']);
            ?>

            <!-- Media / Images -->
            <?= $this->Form->fieldsetStart(['legend' => 'Images', 'collapsed' => false]);  ?>
            <?= $this->Form->control('image_file', ['type' => 'media_picker', 'config' => 'images']); ?>
            <?php /* $this->cell('Media.ImageSelect', [[
        'label' => 'Additional Images',
        'model' => 'Content.Articles',
        'id' => $article->id,
        'scope' => 'image_files',
        'multiple' => true,
        'image' => $article->image_files,
        'imageOptions' => ['width' => 200]
    ]]); */ ?>
            <?= $this->Form->fieldsetEnd(); ?>

        </div>
    </div>
    <?= $this->Form->end() ?>


    <?php $this->Tabs->create(); ?>
    <!-- Advanced -->
    <?php $this->Tabs->add(__d('content', 'Advanced')); ?>
    <div class="form">
        <?= $this->Form->create($article, ['horizontal' => true]); ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => false]); ?>
        <?php
        echo $this->Form->control('refscope');
        echo $this->Form->control('refid');
        echo $this->Form->control('cssclass');
        echo $this->Form->control('cssid');
        echo $this->Form->control('order');
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <!-- Submit -->
        <?= $this->Form->submit(__d('content','Save Changes')) ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- Meta -->
    <?php $this->Tabs->add(__d('content', 'Meta')); ?>
    <div class="form">
        <?= $this->Form->create($article, ['horizontal' => true]); ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Meta', 'collapsed' => false]); ?>

        <?= $this->Form->control('meta_title'); ?>
        <?= $this->Form->control('meta_desc'); ?>
        <?= $this->Form->control('meta_keywords'); ?>
        <?= $this->Form->control('meta_lang'); ?>
        <?= $this->Form->control('meta_robots'); ?>

        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->submit(__d('content','Save Changes')) ?>
        <?= $this->Form->end() ?>
    </div>


    <!-- Related Articles -->
    <?php $this->Tabs->add(__d('content', 'Subposts')); ?>
    <?php if (!$article->parent_id): ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Articles', 'collapsed' => false]);  ?>
        <div class="child-posts">

            <?= $this->cell('Backend.DataTable', [[
                'paginate' => false,
                'sortable' => true,
                'model' => 'Content.Articles',
                'data' => $article->children,
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
                    [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit']],
                    [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
                ]
            ]]);
            ?>

            <?= $this->Html->link(__d('content', 'Add post'), ['action' => 'add', 'parent_id' => $article->id], ['class' => 'btn btn-primary']); ?>
        </div>
        <?= $this->Form->fieldsetEnd(); ?>
    <?php endif; ?>

    <!-- Debug -->
    <?php $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]); ?>
    <?= $this->cell('Backend.EntityView', [$article], ['model' => 'Content.Articles']); ?>
    <?php debug($article); ?>

    <?php echo $this->Tabs->render(); ?>

</div>