<?php
$pages = \Cake\ORM\TableRegistry::getTableLocator()->get('Content.Articles')
    ->find('list', ['keyPath' => 'id', 'valuePath' => 'title'])
    ->where(['Articles.type' => 'page'])
    ->toArray();

echo $this->Form->control('type_params.article_id', [
    'label' => __d('content', 'Page'),
    'options' => $pages,
    'empty' => __('Select page'),
    'required' => true
]);
