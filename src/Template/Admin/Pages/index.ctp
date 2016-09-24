<?php $this->Html->addCrumb(__d('content','Content'), ['controller' => 'Pages', 'action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','Pages'), ['controller' => 'Pages', 'action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','List pages')); ?>
<?php
// TOOLBAR
$this->Toolbar->addLink(__d('content','{0} (Table)', __d('content','Pages')), ['action' => 'table'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus', 'class' => 'link-frame-modal']);
$this->Toolbar->addLink(__d('content','Repair'), ['action' => 'repair'], ['data-icon' => 'wrench']);

$this->loadHelper('Backend.Datepicker');

$this->extend('/Admin/Base/index_jstree_ajax');

$this->set('dataUrl', ['action' => 'treeData']);
$this->set('viewUrl', ['action' => 'treeView']);

//$this->assign('heading', __d('content', 'Pages'));
$this->assign('treeHeading', __d('content', 'Pages'));

?>
<?= __d('content', 'Select a page'); ?>