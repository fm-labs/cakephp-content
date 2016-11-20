<?php
if ($post->ref && $post->ref instanceof \Content\Model\Entity\Page) {
    $this->Html->addCrumb($post->ref->title, ['controller' => 'Pages', 'action' => 'manage', $post->ref->id]);
} else {
    $this->Html->addCrumb(__d('content','Posts'), ['action' => 'index']);
    $this->Html->addCrumb(__d('content','Edit {0}', __d('content','Post')));
}
?>
<?php
// TOOLBAR

$this->Toolbar->addLink([
    'title' => __d('content','Manage'),
    'url' => ['action' => 'manage', $post->id],
    'attr' => ['data-icon' => 'gears']
]);
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

$this->extend('/Admin/Content/edit');
$this->assign('heading', $post->title);
$this->assign('title', $post->title);

// HtmlEditor config
$editor = \Cake\Core\Configure::read('Content.HtmlEditor.default');
$editor['body_class'] = $post->cssclass;
$editor['body_id'] = $post->cssid;
?>
<?= $this->Form->create($post); ?>
<div class="row">
    <div class="col-md-9">

        <?php
        echo $this->Form->input('title');
        echo $this->Form->input('slug');
        //echo $this->Form->input('subheading');
        ?>
        <?= $this->Form->fieldsetStart(['legend' => 'Teaser', 'collapsed' => !($post->use_teaser || $post->teaser_html)]);  ?>
        <?php
        echo $this->Form->input('use_teaser');
        echo $this->Form->input('teaser_html', [
            'type' => 'htmleditor',
            'editor' => $editor
        ]);
        echo $this->Form->input('teaser_link_caption');
        echo $this->Form->input('teaser_link_href');
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
        <?php
        echo $this->Form->input('body_html', [
            'type' => 'htmleditor',
            'editor' => $editor
        ]);
        ?>
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

        <?= $this->Form->fieldsetStart(['legend' => 'Publish']); ?>
        <?php
        echo $this->Form->input('is_published');
        echo $this->Form->input('publish_start_date', ['type' => 'datepicker']);
        echo $this->Form->input('publish_end_date', ['type' => 'datepicker']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->fieldsetStart(['legend' => 'Layout', 'collapsed' => true]); ?>
        <?php
        echo $this->Form->input('teaser_template', ['empty' => '- Default -']);
        echo $this->Form->input('template', ['empty' => '- Default -']);
        ?>
        <?= $this->Form->fieldsetEnd(); ?>

        <?= $this->Form->fieldsetStart(['legend' => 'Media', 'collapsed' => false]); ?>
        <?= $this->cell('Media.ImageSelect', [[
            'label' => 'Teaser Image',
            'model' => 'Content.Posts',
            'id' => $post->id,
            'scope' => 'teaser_image_file',
            'image' => $post->teaser_image_file,
            'imageOptions' => ['width' => 200]
        ]]); ?>

        <?= $this->cell('Media.ImageSelect', [[
            'label' => 'Primary Image',
            'model' => 'Content.Posts',
            'id' => $post->id,
            'scope' => 'image_file',
            'image' => $post->image_file,
            'imageOptions' => ['width' => 200]
        ]]); ?>


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



        <?= $this->Form->fieldsetStart(['legend' => 'Advanced', 'collapsed' => true]); ?>
        <div class="ui attached segment form">
            <?php
            echo $this->Form->input('refscope');
            echo $this->Form->input('refid');
            echo $this->Form->input('cssclass');
            echo $this->Form->input('cssid');
            echo $this->Form->input('order');
            ?>
        </div>
        <?= $this->Form->fieldsetEnd(); ?>
    </div>
</div>
<?= $this->Form->end() ?>