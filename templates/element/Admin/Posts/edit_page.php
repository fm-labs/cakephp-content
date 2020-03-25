<?php
// Breadcrumbs
$this->Breadcrumbs->add(__d('content', 'Pages'), ['action' => 'index', 'type' => $article->type]);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Page')));
// Heading
$this->assign('title', $article->title);
?>
<?php if ($article->parent_id): ?>
<?= $this->Html->link(__d('content', 'Show parent post'), ['action' => 'edit', $article->parent_id]); ?>
<?php endif; ?>
<!-- Teaser
<?= $this->Form->fieldsetStart(['legend' => 'Teaser', 'collapsed' => !($article->use_teaser || $article->teaser_html)]);  ?>
<?php
echo $this->Form->control('use_teaser');
echo $this->Form->control('teaser_html', [
    'type' => 'htmleditor',
    'editor' => $editor
]);
echo $this->Form->control('teaser_link_caption');
echo $this->Form->control('teaser_link_href');
echo $this->Form->control('teaser_template', ['empty' => '- Default -']);
echo $this->Form->control('teaser_image_file', ['type' => 'media_picker']);
?>
<?= $this->Form->fieldsetEnd(); ?>
-->
<!-- Content -->
<?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
<?php
echo $this->Form->control('body_html', [
    'type' => 'htmleditor',
    'editor' => $editor
]);
?>
<?= $this->Form->fieldsetEnd(); ?>
