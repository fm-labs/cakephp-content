<?php $this->Breadcrumbs->add(__d('content','Galleries')); ?>
<?php
// TOOLBAR
$this->Toolbar->addLink(__d('content','{0} (Table)', __d('content','Galleries')), ['action' => 'indexTable'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Gallery')), ['action' => 'add'], ['data-icon' => 'plus']);

$this->extend('/Admin/Base/index_jstree_ajax');

//$this->set('dataUrl', ['action' => 'treeData']);
//$this->set('viewUrl', ['action' => 'treeView']);

$this->assign('treeHeading', __d('content','Galleries'));

?>
<?= __d('content', 'Loading {0}', __d('content','Galleries')); ?>&nbsp;...