<div id="menuitem<?= $item['id'] ?>" class="menu-tree-item-wrap" draggable="true">
    <div class="menu-tree-item">
        <?= h($item['title']); ?> (<?= h($item['type'] . "- " . $item['id']); ?>)
        <?= $this->Html->link(__d('content', 'Edit'), ['action' => 'index', '?' => ['menu_item_id' => $item['id']]]); ?>
        <?php if ($item['parent_id'] == null) : ?>
            <?= $this->Html->link(__d('content', 'Select'), ['action' => 'index', '?' => ['menu_id' => $item['id']]]); ?>
        <?php endif; ?>
    </div>

    <?php if (isset($item['children']) && !empty($item['children'])) : ?>
        <?= $this->element('Content.Admin/Menus/tree_form', ['items' => $item['children']]); ?>
    <?php endif; ?>
</div>
