<div class="related content-modules">
    <?= $this->element('Content.Admin/ContentModules/editable_sections', compact('contentModules', 'sections')); ?>

    <hr />

    <h3><?= __d('content', 'Link existing module'); ?></h3>
    <div class="form">
        <?= $this->Form->create(null, ['url' => ['controller' => 'ContentModules', 'action' => 'linkModule', $model, $modelId]]); ?>
        <?= $this->Form->hidden('refscope', ['default' => $model]); ?>
        <?= $this->Form->hidden('refid', ['default' => $modelId]); ?>
        <?= $this->Form->input('module_id', ['options' => $availableModules]); ?>
        <?= $this->Form->input('section', ['options' => $sections]); ?>
        <?= $this->Form->button('Link module'); ?>
        <?= $this->Form->end(); ?>
    </div>

</div>

