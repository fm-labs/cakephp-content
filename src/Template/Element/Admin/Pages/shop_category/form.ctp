<?php
$shopCategoriesTree = \Cake\ORM\TableRegistry::get('Shop.ShopCategories')->find('treelist');

echo $this->Form->input('type_params.shop_category_id', [
    'label' => __d('content', 'Shop Category Id'),
    'options' => $shopCategoriesTree
]);
