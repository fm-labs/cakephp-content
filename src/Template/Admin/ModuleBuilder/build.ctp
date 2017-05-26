<?php
use Banana\View\Form\ViewModuleContext;

$this->Form->addContextProvider('viewmodule', function($request, $data) {
    if ($data['entity'] instanceof \Banana\View\ViewModule) {
        return new ViewModuleContext($request, $data);
    }
});
if (!$module->cellClass) {
    echo '<div class="alert alert-warning">No module class set</div>';
}
debug($module->toArray());
//$moduleCell = $this->module($module->cellClass, $userArgs, $moduleOptions);
?>
<div class="index">
    <div class="row">


        <div class="col-md-6">
            <?php echo $this->Form->create($moduleCell); ?>
            <?php echo $this->Form->allInputs(); ?>
            <?= $this->Form->input('_save', ['type' => 'checkbox', 'default' => 0, 'label' => 'Save (Leave unchecked for preview)']); ?>

            <?= $this->Form->submit('Preview / Save'); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>