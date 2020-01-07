<div id="menuitem<?= $item['id'] ?>" class="menu-tree-item-wrap" draggable="true">
    <div class="menu-tree-item">
        <?= h($item['title']); ?> (<?= h($item['type']); ?>)
        <?= $this->Html->link(__('Edit'), ['menu_item_id' => $item['id']]); ?>
        <?php if ($item['parent_id'] == null) : ?>
            <?= $this->Html->link(__('Select'), ['menu_id' => $item['id']]); ?>
        <?php endif; ?>
    </div>

    <?php if (isset($item['children']) && !empty($item['children'])) : ?>
        <?= $this->element('Content.Admin/Menus/tree_form', ['items' => $item['children']]); ?>
    <?php endif; ?>
</div>
