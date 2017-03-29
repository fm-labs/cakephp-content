<?php
use Banana\View\Form\ViewModuleContext;

$this->Form->addContextProvider('viewmodule', function($request, $data) {
    if ($data['entity'] instanceof \Banana\View\ViewModule) {
        return new ViewModuleContext($request, $data);
    }
});
$module = $this->module($moduleClass, $userArgs, $moduleOptions);
$module->loadSources();
?>
<div class="index">
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->Form->create($module); ?>
            <?php echo $this->Form->allInputs(); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>