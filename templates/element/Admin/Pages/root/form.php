<?php
echo $this->Form->control('type_params.redirect_page_id', [
    'options' => $menuTreeList,
    'empty' => __d('content', 'No selection')
]);
echo $this->Form->control('type_params.redirect_location', [
]);
echo $this->Form->error('type_params');
echo $this->Form->error('type_params.redirect_page_id');
echo $this->Form->error('type_params.redirect_location');
