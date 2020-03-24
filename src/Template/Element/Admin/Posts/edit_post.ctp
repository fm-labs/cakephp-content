<?php
// Breadcrumbs
$this->Breadcrumbs->add(__d('content', 'Articles'), ['action' => 'index', 'type' => $article->type]);
$this->Breadcrumbs->add(__d('content','Edit {0}', __d('content', 'Article')));
// Heading
$this->assign('title', $article->title);
?>
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

<?= $this->Form->fieldsetStart(['legend' => 'Content', 'collapsed' => false]);  ?>
<?php
echo $this->Form->control('body_html', [
    'type' => 'htmleditor',
    'editor' => $editor
]);
?>
<?= $this->Form->fieldsetEnd(); ?>
