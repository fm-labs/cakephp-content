<?php
$this->Breadcrumbs->add(__('Module Builder'), ['action' => 'index']);
$this->Breadcrumbs->add(__('Build/Edit Module'));

$this->assign('title', ($module->name) ?: __('New module'));
?>
<?php $this->loadHelper('AdminLte.Box'); ?>
<div class="module-builder ui grid">
    <div class="row">
        <div class="build-container col-md-4">
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

        </div>
        <div class="preview-container col-md-8">
            <?= $this->Box->create('Preview'); ?>

            <?= '' // $this->cell($module->path . 'Module', [], ['module' => $module, 'section' => $section, 'page_id' => $page_id]) ?>
            <?php if (isset($previewUrl)): ?>
                <?= $this->Html->link('Open in new window', $previewUrl, ['target' => '_blank']); ?>
            <iframe src="<?= $this->Url->build($previewUrl); ?>" style="width: 750px; height: 600px; border: none;"></iframe>
            <?php endif; ?>
            <?= $this->Box->render(); ?>
        </div>
    </div>


</div>


<?php debug($module); debug($previewUrl); debug($this->Url->build($previewUrl));  ?>
<?php debug($data); ?>
        