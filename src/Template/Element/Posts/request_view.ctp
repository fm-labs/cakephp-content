<?php
try {
    //$url = $this->Url->build(['plugin' => 'Content', 'controller' => 'Articles', 'action' => 'view', $article->id]);
    $url = '/content/posts/view/' . $article->id;
    /* @var \Cake\View\View $this */
    echo $this->requestAction($url, ['return']);
} catch (\Exception $ex) {
    debug($ex->getMessage());
    debug($ex->getTraceAsString());
    \Cake\Log\Log::error('Failed to fetch post with ID ' . $article->id . ': ' . $ex->getMessage());
}