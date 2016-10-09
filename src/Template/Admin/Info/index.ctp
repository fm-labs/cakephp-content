<?php
use Content\Lib\ContentManager;
?>
<div class="content info index">

    <h1>Content Information</h1>


    <h3>
        getAvailablePageTypes
    </h3>
    <?php var_dump(ContentManager::getAvailablePageTypes()); ?>


    <h3>
        getAvailablePageLayouts
    </h3>
    <?php var_dump(ContentManager::getAvailablePageLayouts()->toArray()); ?>

    <h3>
        getDefaultPageLayout
    </h3>
    <?php var_dump(ContentManager::getDefaultPageLayout()); ?>

    <h3>
        getModulesAvailable
    </h3>
    <?php var_dump(ContentManager::getModulesAvailable()); ?>
</div>