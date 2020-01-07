<ul class="<?= $class; ?> level-<?= $level ?>" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
<?php foreach ($menu as $node): ?>
    <?php
        $title = $node['title'];
        $url = $node['url'];
        $attr = (isset($node['attr']) && is_array($node['attr'])) ? $node['attr'] : [];
        $attr['itemprop'] = 'url';
    ?>
    <li><?= $this->Html->link($title, $url, $attr); ?>
    <?php if ($node['children']): ?>
        <?php echo $this->element($element, ['menu' => $node['children'], 'level' => $level + 1, 'class' => $class, 'element' => $element]); ?>
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
