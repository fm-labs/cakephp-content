<div class="menu-tree-items">
    <?php foreach ($items as $item): ?>
        <?= $this->element('Content.Admin/Menus/tree_form_item', ['item' => $item]); ?>
    <?php endforeach; ?>
</div>