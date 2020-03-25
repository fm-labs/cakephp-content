<?php
echo $this->Form->control('type_params__controller', [
]);
?>
<?php
echo $this->Form->control('type_params__controller_action', []);
?>
<?php
echo $this->Form->control('type_params__redirect_page_id', [
    'options' => $pagesTree,
    'empty' => __d('content','No selection')
]);
?>
<?php
echo $this->Form->control('type_params__status', [
    'options' => [301 => 'Permanent (301)', 302 => 'Temporary (302)'],
    'default' => 302
]);
?>