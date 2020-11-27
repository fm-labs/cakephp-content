<?php
$pages = \Cake\ORM\TableRegistry::getTableLocator()->get('Content.Pages')
    ->find('list', ['keyPath' => 'id', 'valuePath' => 'title'])
    ->where(['Pages.type' => 'page'])
    ->toArray();

echo $this->Form->control('type_params.page_id', [
    'label' => __d('content', 'Page'),
    'options' => $pages,
    'empty' => __('Select page'),
    'required' => true
]);
