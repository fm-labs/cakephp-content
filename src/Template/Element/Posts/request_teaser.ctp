<?php
try {
    $url = $this->Url->build(['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'teaser', $post->id]);
    echo $this->requestAction($url);
} catch (\Exception $ex) {
    debug($ex->getMessage());
    \Cake\Log\Log::error('Failed to fetch teaser for post with ID ' . $post->id . ': ' . $ex->getMessage());
}