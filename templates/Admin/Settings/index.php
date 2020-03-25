<?php $this->loadHelper('Backend.Box'); ?>
<?php $this->loadHelper('Bootstrap.Ui'); ?>
<div class="index">
    <?php
    $this->Form->addContextProvider('settings_form', function($request, $context) {
        if ($context['entity'] instanceof \Settings\Form\SettingsForm) {
            return new \Settings\View\Form\SettingsFormContext($request, $context);
        }
    });
    ?>
    <?= $this->Form->create(); ?>
    <div class="row">
        <div class="col-md-3">
            <?php $this->Box->create(__('Routing')); ?>
            <?= $this->Form->control('Content.Router.enablePrettyUrls'); ?>
            <?= $this->Form->control('Content.Router.enableRootScope'); ?>
            <?= $this->Form->control('Content.Router.forceCanonical'); ?>
            <?= $this->Box->render(); ?>
        </div>
        <div class="col-md-3">
            <?= $this->Box->create(__('Pages')); ?>
            <?= $this->Box->render(); ?>
        </div>
        <div class="col-md-3">
            <?= $this->Box->create(__('Posts')); ?>
            <?= $this->Box->render(); ?>
        </div>
    </div>
    <?= $this->Form->submit(); ?>
    <?= $this->Form->end(); ?>
</div>