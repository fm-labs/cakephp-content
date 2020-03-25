<?php
$sections = (isset($sections)) ? $sections : [];
$contentModules = (isset($contentModules)) ? $contentModules : [];
?>
<?php foreach($sections as $section): ?>
    <h4><?= \Cake\Utility\Inflector::humanize($section); ?></h4>
    <?php echo $this->element(
        'Content.Admin/ContentModules/editable_content_modules',
        ['contentModules' => $contentModules, 'section' => $section]);
    ?>
<?php endforeach; ?>