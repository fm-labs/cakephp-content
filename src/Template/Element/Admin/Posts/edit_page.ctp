<?php
// Breadcrumbs
$this->Html->addCrumb(__('Pages'), ['action' => 'index', 'type' => $post->type]);
$this->Html->addCrumb(__d('content','Edit {0}', __d('content', 'Page')));
// Heading
$this->assign('title', $post->title);
?>
<?php if ($post->parent_id): ?>
<?= $this->Html->link(__('Show parent post'), ['action' => 'edit', $post->parent_id]); ?>
<?php endif; ?>
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
