<?php
$this->loadHelper('AdminLte.Box');
$this->loadHelper('Bootstrap.Tabs');
$this->loadHelper('Media.Media');

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
            <?php foreach($post->children as $_post): ?>

                <?= $this->Box->create(['collapsed' => true]); ?>
                <!-- Box Heading -->
                <?= $this->Box->heading(); ?>
                <?= h($_post->title); ?>
                <br />
                <?= $this->Ui->statusLabel($_post->is_published, [], [
                    0 => [__('Unpublished'), 'default'],
                    1 => [__('Published'), 'success']
                ]); ?>
                <?= $this->Html->link('Edit Post', ['plugin' => 'content', 'controller' => 'Posts', 'action' => 'edit', $_post->id], ['class' => 'btn btn-sm']); ?>

                <!-- Box Body -->
                <?= $this->Box->body(); ?>

                <!-- Tab Quick Edit -->
                <?php $this->Tabs->create(); ?>
                <?php $this->Tabs->add('Quick Edit'); ?>

                <?= $this->Form->create($_post, ['data-ajax' => 1, 'url' => ['action' => 'edit', 'parent_id' => $post->id, '_ext' => 'json']]); ?>
                <?= $this->Form->hidden('id'); ?>
                <?= $this->Form->hidden('type'); ?>
                <?= $this->Form->input('title'); ?>
                <?= $this->Form->input('body_html', [
                    'type' => 'htmleditor',
                    'editor' => $editor
                ]); ?>
                <?= $this->Form->button(__('Save')); ?>
                <?= $this->Form->end(); ?>

                <!-- Tab Preview -->
                <?php $this->Tabs->add('Preview'); ?>
                <div class="page-preview">
                    <?php echo $this->Content->userHtml($_post->body_html); ?>
                </div>

                <?php echo $this->Tabs->render(); ?>
                <?= $this->Box->render(); ?>
            <?php endforeach; ?>

            <?= $this->Html->link(__('Add post'), ['action' => 'add', 'parent_id' => $post->id], ['class' => 'btn btn-primary']); ?>
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