<h3><?= __d('content', 'Related Articles'); ?></h3>
<?php $articles = $this->requestAction(['action' => 'relatedArticles', $page->id], ['return']); ?>
<?php echo $articles; ?>