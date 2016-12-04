<?php
// Breadcrumbs
$this->Html->addCrumb(__('Posts'), ['action' => 'index', 'type' => $post->type]);
$this->Html->addCrumb(__d('content','Edit {0}', __d('content', 'Post')));
// Heading
$this->assign('title', $post->title);
?>
<h1>Edit Post</h1>
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

<?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
<?php
echo $this->Form->input('body_html', [
    'type' => 'htmleditor',
    'editor' => $editor
]);
?>
<?= $this->Form->fieldsetEnd(); ?>
