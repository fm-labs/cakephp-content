<h3><?= __d('content', 'Related Posts'); ?></h3>
<?php $posts = $this->requestAction(['action' => 'relatedPosts', $page->id], ['return']); ?>
<?php echo $posts; ?>