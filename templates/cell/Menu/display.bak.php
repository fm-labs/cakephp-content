<?php
$level = $this->get('level');
$menu = $this->get('menu');
$class = $this->get('class');
?>
<ul class="<?= $class; ?> level-<?= $level ?>" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
<?php foreach ($menu as $item) : ?>
    <?php
        $title = $item['title'];
        $url = $item['url'];
        $attr = isset($item['attr']) && is_array($item['attr']) ? $item['attr'] : [];
        $attr['itemprop'] = 'url';
    ?>
    <li><?= $this->Html->link($title, $url, $attr); ?>
    <?php if ($item['children']) : ?>
        <?= $this->cell('Content.Menu', ['menu' => $item['children'], 'level' => $level + 1, 'class' => $class]); ?>
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
