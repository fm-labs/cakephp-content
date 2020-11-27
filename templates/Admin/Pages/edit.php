<?php
/**
 * @var \Content\Model\Entity\Page $page
 * @var array $editor Htmleditor config
 * @var array $attributes Model attributes schema
 */
$this->loadHelper('Bootstrap.Tabs');
//$this->loadHelper('Media.MediaPicker');

// Toolbar
$this->Toolbar->addLink([
    'title' => __d('content','Preview'),
    'url' => ['action' => 'preview', $page->id],
    'attr' => ['data-icon' => 'eye', 'target' => 'preview']
]);
$this->Toolbar->addLink([
    'title' => __d('content','View'),
    'url' => ['action' => 'view', $page->id],
    'attr' => ['data-icon' => 'eye']
]);
$this->Toolbar->addPostLink([
    'title' => __d('content','Delete'),
    'url' => ['action' => 'delete', $page->id],
    'attr' => ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $page->id)],
]);
?>
<?php
// Breadcrumbs
$this->Breadcrumbs->add(__d('content', 'Pages'), ['action' => 'index']);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Page')));

// Heading
$this->assign('title', $page->title);
$this->assign('heading', $page->title);

if ($page->parent_id):
    $this->assign('heading', $this->Html->link($page->parent->title, ['action' => 'edit', $page->parent->id, 'type' => $page->parent->type]));
    $this->assign('subheading', $page->title);
endif;
?>
<div class="edit">
    <?= $this->Form->create($page); ?>
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
                'type' => 'htmleditor',
                'editor' => $editor
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
            echo $this->Form->control('is_published', []);
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
        'model' => 'Content.Pages',
        'id' => $page->id,
        'scope' => 'image_files',
        'multiple' => true,
        'image' => $page->image_files,
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
        <?= $this->Form->create($page, ['horizontal' => true]); ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => false]); ?>
        <?php
        echo $this->Form->control('refscope');
        echo $this->Form->control('refid');
        echo $this->Form->control('cssclass');
        echo $this->Form->control('cssid');
        echo $this->Form->control('order');
        ?>
        <?= $this->Form->fieldsetEnd(); ?>


        <?= $this->Form->create($page, ['horizontal' => true]); ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Options', 'collapsed' => false]); ?>

        <?php foreach($attributes as $aName => $aConfig):  ?>
            <?= $this->Form->control($aName, $aConfig['input']); ?>
        <?php endforeach; ?>

        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->submit(__d('content','Save Changes')) ?>
        <?= $this->Form->end() ?>
    </div>


    <!-- Related Pages -->
    <?php $this->Tabs->add(__d('content', 'Subposts')); ?>
    <?php if (!$page->parent_id): ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Pages', 'collapsed' => false]);  ?>
        <div class="child-posts">

            <?= $this->cell('Admin.DataTable', [[
                'paginate' => false,
                'sortable' => true,
                'model' => 'Content.Pages',
                'data' => $page->children,
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

            <?= $this->Html->link(__d('content', 'Add post'), ['action' => 'add', 'parent_id' => $page->id], ['class' => 'btn btn-primary']); ?>
        </div>
        <?= $this->Form->fieldsetEnd(); ?>
    <?php endif; ?>

    <!-- Debug -->
    <?php $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]); ?>
    <?= $this->cell('Admin.EntityView', [$page], ['model' => 'Content.Pages']); ?>
    <?php debug($page); ?>

    <?php echo $this->Tabs->render(); ?>

</div>