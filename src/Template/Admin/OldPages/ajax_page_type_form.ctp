<?php foreach($inputs as $input => $config) {
    echo $this->Form->control($input, $config);
}
return;
?>

<div class="select-type select-type-redirect select-type-root">
    <?php
    echo $this->Form->control('redirect_location', [
    ]);
    ?>
</div>
<div class="select-type select-type-controller select-type-module select-type-cell">
    <?php
    echo $this->Form->control('redirect_controller', [
    ]);
    ?>
</div>
<div class="select-type select-type-page select-type-root">
    <?php
    echo $this->Form->control('redirect_page_id', [
        'options' => $pagesTree,
        'empty' => __d('content','No selection')
    ]);
    ?>
</div>
<div class="select-type select-type-redirect select-type-controller select-type-page select-type-root">
    <?php
    echo $this->Form->control('redirect_status', [
        'options' => [301 => 'Permanent (301)', 302 => 'Temporary (302)'],
        'default' => 302
    ]);
    ?>
</div>