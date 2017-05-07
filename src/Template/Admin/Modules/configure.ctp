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


$moduleCell = $this->module($module->cellClass, $userArgs, $moduleOptions);
?>
<?php $this->Breadcrumbs->add(__d('content','Modules'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Configure')); ?>
<div class="index">
    <h3><?= h($module->name); ?></h3>
    <?= $this->Html->link(__('Edit {0}', __('module')), ['action' => 'edit', $module->id]); ?>

    <div class="row">
        <div class="col-md-4">
            <?php echo $this->Form->create($moduleCell); ?>
            <?php echo $this->Form->allInputs([], ['fieldset' => false]); ?>
            <?= $this->Form->input('_save', ['type' => 'checkbox', 'default' => 0, 'label' => 'Save (Leave unchecked for preview)']); ?>

            <?= $this->Form->submit('Preview / Save'); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="col-md-8">
            <strong><?= h($previewUrl); ?></strong>
            <?php if (isset($previewUrl)): ?>
                <iframe src="<?= $this->Url->build($previewUrl); ?>" style="width: 100%; height: 1000px; border: none;"></iframe>
            <?php endif; ?>
        </div>
    </div>
</div>
<hr />
<?php
debug($this->request->data);
debug($module);
?>