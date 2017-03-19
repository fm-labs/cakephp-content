<?php
if (empty($params['gallery_id'])) {
    echo "GALLERY ID NOT SET";
    return;
}

try {
    $url = ['prefix' => false, 'plugin' => 'Content',  'controller' => 'Galleries', 'action' => 'view', $params['gallery_id']];
    $url = $this->Url->build($url);
    echo $this->requestAction($url);
} catch (\Exception $ex) {
    debug($ex->getMessage());
    \Cake\Log\Log::error('Failed to display flexslider for gallery with ID ' . $params['gallery_id'] . ': ' . $ex->getMessage());
}