<?php $this->loadHelper('Cupcake.Menu'); ?>
<div class="container-fluid">
    <h1>Configured Menus</h1>

    <?php foreach($this->get('menus') as $menuName): ?>
    <h3><?= $menuName; ?></h3>
        <?php
        $menu = \Cupcake\Menu\MenuManager::get($menuName)->toArray();
        debug($menu);
        $this->Menu->create($menu);
        echo $this->Menu->render();
        ?>
    <?php endforeach; ?>
</div>