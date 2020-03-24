<?php
$shopCategoriesTree = \Cake\ORM\TableRegistry::getTableLocator()->get('Shop.ShopCategories')->find('treelist');

echo $this->Form->control('type_params.shop_category_id', [
    'label' => __d('content', 'Shop Category Id'),
    'options' => $shopCategoriesTree
]);
