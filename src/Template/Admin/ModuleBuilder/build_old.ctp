<?php
$this->Breadcrumbs->add(__('Module Builder'), ['action' => 'index']);
$this->Breadcrumbs->add(__('Build/Edit Module'));

$this->assign('title', ($module->name) ?: __('New module'));
?>
<?php $this->loadHelper('AdminLte.Box'); ?>
<div class="module-builder ui grid">
    <div class="row">
        <div class="build-container col-md-3">
            <?= $this->Box->create('Configure Module'); ?>
                <?= $this->Form->create($module, [
                    'url' => [
                        'action' => 'build',
                        'path' => $module->path,
                    ],
                    'class' => 'no-ajax'
                ]); ?>
                <?= $this->Form->input('id'); ?>
                <?= $this->Form->input('name'); ?>
                <?= $this->Form->input('path'); ?>

                <?php foreach ($formInputs as $field => $fieldOptions) {
                    echo $this->Form->input($field, $fieldOptions);
                }
                ?>

                <?= $this->Form->hidden('params', ['disabled' => true]); ?>
                <?= $this->Form->input('_save', ['type' => 'checkbox', 'default' => 0, 'label' => 'Save (Leave unchecked for preview)']); ?>

                <?= $this->Form->submit('Preview / Save'); ?>
                <?= $this->Form->end(); ?>
            <?= $this->Box->render(); ?>

            <?php if (isset($previewUrl)): ?>
            <?= $this->Box->create('Preview'); ?>
            <?= $this->Html->link('Open in new window', $previewUrl, ['target' => '_blank']); ?>
            <?= $this->Box->render(); ?>
            <?php endif; ?>
        </div>
        <div class="preview-container col-md-9">

            <?php if (isset($previewUrl)): ?>
                <iframe src="<?= $this->Url->build($previewUrl); ?>" style="width: 100%; height: 1000px; border: none;"></iframe>
            <?php endif; ?>
        </div>
    </div>


</div>


<?php debug($module); debug($previewUrl); debug($this->Url->build($previewUrl));  ?>
<?php debug($data); ?>
        