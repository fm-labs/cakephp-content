<div class="related content-modules">

    <?php //echo $this->element('Content.Admin/Content/related_content_modules', compact('content', 'sections')); ?>
    <!--
    <br />
    <?= $this->Ui->link('Build a new module for this page', [
        'controller' => 'ModuleBuilder',
        'action' => 'build',
        'refscope' => 'Content.Pages',
        'refid' => $content->id
    ], ['class' => 'btn btn-default', 'data-icon' => 'plus']); ?>
    -->

    <div class="row">
        <div class="col-md-12">
            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'top']);
            ?>
            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'before']);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">

            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'left']);
            ?>
        </div>
        <div class="col-md-6">

            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'main']);
            ?>
        </div>
        <div class="col-md-3">

            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'right']);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'after']);
            ?>
            <?php echo $this->element(
                'Content.Admin/Content/list_content_modules_editable',
                ['contentModules' => $content->content_modules, 'section' => 'bottom']);
            ?>
        </div>
    </div>

    <hr />
    <h3><?= __d('content', 'Link existing module'); ?></h3>
    <div class="form">
        <?= $this->Form->create(null, ['url' => ['action' => 'linkModule', $content->id]]); ?>
        <?= $this->Form->hidden('refscope', ['default' => 'Content.Pages']); ?>
        <?= $this->Form->hidden('refid', ['default' => $content->id]); ?>
        <?= $this->Form->input('module_id', ['options' => $availableModules]); ?>
        <?= $this->Form->input('section'); ?>
        <?= $this->Form->button('Link module'); ?>
        <?= $this->Form->end(); ?>
    </div>

</div>

