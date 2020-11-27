<h3><?= __d('content', 'Related Pages'); ?></h3>
<?php $pages = $this->requestAction(['action' => 'relatedPages', $page->id], ['return']); ?>
<?php echo $pages; ?>