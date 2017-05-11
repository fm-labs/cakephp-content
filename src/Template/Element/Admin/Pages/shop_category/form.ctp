<?php
$shopCategoriesTree = \Cake\ORM\TableRegistry::get('Shop.ShopCategories')->find('treelist');

echo $this->Form->input('redirect_location', [
    'label' => __('Shop Category Id'),
    'options' => $shopCategoriesTree
]);
?>