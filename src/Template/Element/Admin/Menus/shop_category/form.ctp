<?php
$shopCategoriesTree = \Cake\ORM\TableRegistry::getTableLocator()->get('Shop.ShopCategories')->find('treelist');

echo $this->Form->control('type_params.title', [
    'label' => __d('content', 'Custom Title'),
    'help' => 'foo',
    'required' => false
]);
echo $this->Form->control('type_params.shop_category_id', [
    'label' => __d('content', 'Shop Category Id'),
    'options' => $shopCategoriesTree,
    'required' => true
]);

echo $this->Form->control('type_params.shop_subcategories_depth', [
    'label' => __d('content', 'Number of subcategories depth'),
    'default' => -1,
    'options' => [-1 => __('All'), 0, 1, 2, 3, 4, 5],
    'required' => false
]);
