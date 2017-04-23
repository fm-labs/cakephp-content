<?php
echo $this->Form->input('redirect_location', [
]);
?>
<?php
echo $this->Form->input('redirect_controller', []);
?>
<?php
echo $this->Form->input('redirect_page_id', [
    'options' => $pagesTree,
    'empty' => __d('content','No selection')
]);
?>
<?php
echo $this->Form->input('redirect_status', [
    'options' => [301 => 'Permanent (301)', 302 => 'Temporary (302)'],
    'default' => 302
]);
?>