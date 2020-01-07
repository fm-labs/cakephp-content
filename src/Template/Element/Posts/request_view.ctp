<?php
try {
    //$url = $this->Url->build(['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view', $post->id]);
    $url = '/content/posts/view/' . $post->id;
    /* @var \Cake\View\View $this */
    echo $this->requestAction($url, ['return']);
} catch (\Exception $ex) {
    debug($ex->getMessage());
    debug($ex->getTraceAsString());
    \Cake\Log\Log::error('Failed to fetch post with ID ' . $post->id . ': ' . $ex->getMessage());
}