<?php
//$this->loadHelper('Bootstrap.Tabs');
//$this->extend('/Admin/Content/edit');

$this->Breadcrumbs->add(__('Pages'), ['action' => 'index']);
$this->Breadcrumbs->add($page->title);

// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $page->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $page->id)]
);
//$this->Toolbar->addLink(__d('content','List {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
//$this->Toolbar->addLink(__d('content','Manage'), ['action' => 'manage', $page->id], ['class' => 'link-manage']);
$this->Toolbar->addLink(__d('content','View'), ['action' => 'view', $page->id], ['class' => 'view']);
//$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $page->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['class' => 'add']);


// HEADING
$this->assign('title', $page->title);

// CONTENT
?>
<div class="pages form">

    <?= $this->Form->create($page, ['novalidate' => 'novalidate', 'horizontal' => false]); ?>

    <div class="row">
        <div class="col-md-9">
            <?php
            echo $this->Form->input('title');
            echo $this->Form->input('slug');
            ?>
            <?php
            echo $this->Form->input('type', [
                'id' => 'select-type',
                //'class' => 'select-ajax',
                //'data-target' => 'select-type-params-form',
                //'data-url' => ['action' => 'ajaxPageTypeForm']
            ]);
            ?>
            <div id="select-type-params-form"></div>
            <div class="select-type select-type-redirect select-type-root">
                <?php
                echo $this->Form->input('redirect_location', [
                ]);
                ?>
            </div>
            <div class="select-type select-type-controller select-type-module select-type-cell">
                <?php
                echo $this->Form->input('redirect_controller', [
                ]);
                ?>
            </div>
            <div class="select-type select-type-page select-type-root">
                <?php
                echo $this->Form->input('redirect_page_id', [
                    'options' => $pagesTree,
                    'empty' => __d('content','No selection')
                ]);
                ?>
            </div>
            <div class="select-type select-type-redirect select-type-controller select-type-page select-type-root">
                <?php
                echo $this->Form->input('redirect_status', [
                    'options' => [301 => 'Permanent (301)', 302 => 'Temporary (302)'],
                    'default' => 302
                ]);
                ?>
            </div>
        </div>
        <div class="col-md-3">

            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Navigation'), 'collapsed' => false]); ?>
            <?= $this->Form->input('hide_in_nav'); ?>
            <?= $this->Form->input('hide_in_sitemap'); ?>
            <?= $this->Form->fieldsetEnd(); ?>


            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Layout'), 'collapsed' => true]); ?>
            <?php
            echo $this->Form->input('page_layout_id',
                ['empty' => true, 'options' => $pageLayouts, 'data-placeholder' => __d('content', 'Use default')]);
            ?>
            <?php
            if ($page->page_layout_id) {
                echo $this->Html->link('Edit Layout', '#');
            }
            ?>
            <?php
            echo $this->Form->input('page_template',
                //['type' => 'text']
                ['empty' => true, 'options' => $pageTemplates, 'data-placeholder' => __d('content', 'Use default')]
            );
            ?>
            <?= $this->Form->fieldsetEnd(); ?>


            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Advanced'), 'collapsed' => true]); ?>
            <?= $this->Form->input('cssid'); ?>
            <?= $this->Form->input('cssclass'); ?>
            <?= $this->Form->fieldsetEnd(); ?>


            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Publish'), 'collapsed' => false]); ?>
            <?php
            echo $this->Form->input('is_published');
            ?>
            <?php echo $this->Form->input('publish_start_date', ['type' => 'datepicker']); ?>
            <?php echo $this->Form->input('publish_end_date', ['type' => 'datepicker']); ?>
            <?= $this->Form->fieldsetEnd(); ?>

            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Parent'), 'collapsed' => false]); ?>
            <?php
            echo $this->Form->input('parent_id',
                ['options' => $pagesTree, 'empty' => '- Root Node -']);

            if ($page->parent_id) {
                echo $this->Html->link(__('Edit parent'), ['action' => 'edit', $page->parent_id]);
            }
            ?>
            <?= $this->Form->fieldsetEnd(); ?>
        </div>

    </div>

    <div class="actions">
        <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'save btn btn-primary']) ?>
    </div>

    <?= $this->Form->end() ?>
    <!-- EOF PAGE EDIT FORM -->

    <?php debug($page); ?>
</div>

