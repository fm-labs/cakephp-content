<ul class="<?= $class; ?> level-<?= $level ?>">
<?php foreach ($menu as $node): ?>
    <li><?= $this->Html->link($node['title'], $node['url'], $node['attr']); ?>
    <?php if ($node['_children']): ?>
        <?php echo $this->element('Content.Modules/Menu/List/display', ['menu' => $node['_children'], 'level' => $level + 1, 'class' => $class]); ?>
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
