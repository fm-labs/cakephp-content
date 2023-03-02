<?php
use Content\ContentManager;

$this->loadHelper('Bootstrap.Tabs');
$this->loadHelper('Bootstrap.Menu');
$this->loadHelper('Bootstrap.Ui');
?>
<div class="content info index">

    <h1>Content Information</h1>

    <?= $this->Tabs->create(); ?>
    <?= $this->Tabs->add(__d('content', 'Menus')); ?>

    <h3>
        getAvailableMenus
    </h3>
    <?php foreach(ContentManager::getAvailableMenus() as $menuId => $menuAlias): ?>
        <?php $menu = ContentManager::getMenuById($menuId); ?>
        <?php debug($menu->toArray()); ?>
        <h4><?= h($menuAlias); ?></h4>
        <?php echo $this->Ui->menu($menu, ['class' => 'test-menu'], ['class' => 'dropdown-menu']); ?>

        <?php echo $this->Menu->create(['items' => $menu, 'classes' => ['menu' => 'test-menu']])->render(); ?>

    <?php endforeach; ?>

    <?= $this->Tabs->add(__d('content', 'Content Manager')); ?>
    <h3>
        getAvailablePageTypes
    </h3>
    <?php var_dump(ContentManager::getAvailablePageTypes()); ?>


    <h3>
        getAvailablePageTemplates
    </h3>
    <?php var_dump(ContentManager::getAvailablePageTemplates()); ?>
    <?= $this->Tabs->render(); ?>