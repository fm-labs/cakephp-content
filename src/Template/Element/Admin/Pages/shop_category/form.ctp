<?php
$shopCategoriesTree = \Cake\ORM\TableRegistry::get('Shop.ShopCategories')->find('treelist');

echo $this->Form->input('redirect_location', [
    'label' => __d('content', 'Shop Category Id'),
    'options' => $shopCategoriesTree
]);
?>