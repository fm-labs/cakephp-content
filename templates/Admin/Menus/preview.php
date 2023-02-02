<?php
$menu = $this->get('menu');

debug($menu);

?>

<div id="content-menu-cell-preview">
    <?php echo $this->module('Content.Menu', [], [
        'menuId' => '__main__',
        'depth' => 2,
        'element_path' => 'Ontalents.Modules/PagesMenu/menu_list',
    ]); ?>
</div>
