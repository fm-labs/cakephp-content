<?php
try {
    $url = $this->Url->build(['plugin' => 'Content', 'controller' => 'Articles', 'action' => 'teaser', $article->id]);
    echo $this->requestAction($url);
    //debug($article->toArray());
} catch (\Exception $ex) {
    debug($ex->getMessage());
    \Cake\Log\Log::error('Failed to fetch teaser for post with ID ' . $article->id . ': ' . $ex->getMessage());
}