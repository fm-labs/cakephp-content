<?php
use Banana\View\Form\ViewModuleContext;

$this->Form->addContextProvider('viewmodule', function($request, $context) {
    if ($context['entity'] instanceof \Banana\View\ViewModule) {
        return new ViewModuleContext($request, $context);
    }
});
if (!$module->cellClass) {
    echo '<div class="alert alert-warning">No module class set</div>';
}
try {

    $moduleCell = $this->module($module->cellClass, $userArgs, $moduleOptions);
} catch (\Exception $ex) {
    echo $ex->getMessage();
}
?>
<?php $this->Breadcrumbs->add(__d('content','Modules'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Configure')); ?>
<div class="index">
    <h3><?= h($module->name); ?></h3>
    <?= $this->Html->link(__d('content', 'Edit {0}', __d('content', 'module')), ['action' => 'edit', $module->id]); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $this->Form->create($moduleCell); ?>
            <?php echo $this->Form->allInputs($moduleCell->inputs(), ['fieldset' => false]); ?>
            <?= $this->Form->input('_save', ['type' => 'checkbox', 'default' => 0, 'label' => 'Save (Leave unchecked for preview)']); ?>

            <?= $this->Form->submit('Preview / Save'); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="col-md-6">
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