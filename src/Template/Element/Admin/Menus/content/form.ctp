<?php
$pages = \Cake\ORM\TableRegistry::get('Content.Posts')
    ->find('list', ['keyPath' => 'id', 'valuePath' => 'title'])
    ->where(['Posts.type' => 'page'])
    ->toArray();

echo $this->Form->input('type_params.post_id', [
    'label' => __d('content', 'Page'),
    'options' => $pages,
    'empty' => __('Select page'),
    'required' => true
]);
