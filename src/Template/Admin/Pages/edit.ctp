<?php
//$this->loadHelper('Bootstrap.Tabs');
$this->extend('/Admin/Content/edit');


// EXTEND: TOOLBAR
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $content->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $content->id)]
);
//$this->Toolbar->addLink(__d('content','List {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','View'), ['action' => 'view', $content->id], ['data-icon' => 'file']);
//$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $content->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);


// HEADING
$this->assign('heading',$content->title);
$this->assign('title', $content->title);

// CONTENT
?>
<div class="pages form">

    <?= $this->Form->create($content, ['novalidate' => 'novalidate']); ?>

    <div class="row">
        <div class="col-md-9">
            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Page'), 'collapsed' => false]); ?>
            <?php
            echo $this->Form->input('parent_id',
                ['options' => $pagesTree, 'empty' => '- Root Node -']);
            ?>
            <?php
            echo $this->Form->input('title');
            echo $this->Form->input('slug');
            ?>
            <!--
            <?php
            echo $this->Form->input('type', [
                'id' => 'select-type',
                'class' => 'select-ajax',
                'data-target' => 'select-type-params-form',
                'data-url' => ['action' => 'ajaxPageTypeForm']
            ]);
            ?>
            <div id="select-type-params-form"></div>
            -->
            <!--
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
            -->
            <?= $this->Form->fieldsetEnd(); ?>


            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Navigation'), 'collapsed' => true]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('hide_in_nav'); ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->input('hide_in_sitemap'); ?>
                </div>
            </div>
            <?= $this->Form->fieldsetEnd(); ?>


            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Layout'), 'collapsed' => true]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('page_layout_id',
                        ['empty' => true, 'options' => $pageLayouts, 'data-placeholder' => __d('content', 'Use default')]);
                    ?>
                    <?php
                    if ($content->page_layout_id) {
                        echo $this->Html->link('Edit Layout', '#');
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('page_template',
                        //['type' => 'text']
                        ['empty' => true, 'options' => $pageTemplates, 'data-placeholder' => __d('content', 'Use default')]
                    );
                    ?>
                </div>
            </div>
            <?= $this->Form->fieldsetEnd(); ?>


            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Advanced'), 'collapsed' => true]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('cssid'); ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->input('cssclass'); ?>
                </div>
            </div>
            <?= $this->Form->fieldsetEnd(); ?>

        </div>
        <div class="col-md-3">

            <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Publish'), 'collapsed' => false]); ?>
            <?php
            echo $this->Form->input('is_published');
            ?>
            <?php echo $this->Form->input('publish_start_date', ['type' => 'datepicker']); ?>
            <?php echo $this->Form->input('publish_end_date', ['type' => 'datepicker']); ?>
            <?= $this->Form->fieldsetEnd(); ?>

        </div>

    </div>

    <div class="actions">
        <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'save btn btn-primary']) ?>
    </div>

    <?= $this->Form->end() ?>
    <!-- EOF PAGE EDIT FORM -->

</div>

