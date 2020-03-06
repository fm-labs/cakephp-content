<div class="module ui form">
    <?= $this->Form->create($module); ?>
    <?= $this->Form->control('id'); ?>
    <?= $this->Form->control('path'); ?>
    <?= $this->Form->control('name'); ?>
    <?= $this->Form->control('post_id', ['options' => $posts]); ?>
    <?php if ($module->post_id): ?>
    <?= $this->Html->link('Edit post', ['controller' => 'Posts', 'action' => 'edit', $module->post_id]); ?>
    <?php endif; ?>
    <div class="ui hidden divider"></div>
    <?= $this->Form->control('_save', ['type' => 'checkbox', 'default' => 0]); ?>
    <?= $this->Form->submit(); ?>
    <?= $this->Form->end(); ?>
</div>
