<?php
use Cake\Utility\Inflector;

$this->loadHelper('Bootstrap.Panel');
$this->loadHelper('Bootstrap.Tabs');
//$this->extend('/Admin/Content/edit');

// EXTEND: TOOLBAR
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);
$this->Toolbar->addLink(__d('content','All {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $page->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','Info', __d('content','Info')), ['action' => 'info', $page->id], ['data-icon' => 'info']);
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $page->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $page->id)]
);

$this->Breadcrumbs->add(__d('content', 'Pages'), ['action' => 'index']);
$this->Breadcrumbs->add($page->title);

// HEADING
$this->assign('title', $page->title);
$this->assign('heading', $page->title);

// LEFT
$this->loadHelper('Bootstrap.Menu');

/*
$this->start('left');

$menu = \Cake\ORM\TableRegistry::get('Content.Pages')->getMenu(null, ['includeHidden' => true]);
echo $this->Menu->create(['items' => $menu])
    ->setUrlCallback(function($page) { return ['action' => 'edit', $page['data-id'] ]; })
    ->render();

$this->end();
*/

// CONTENT
?>
<?php $this->Html->script('/backend/libs/jquery-ui/jquery-ui.min.js', ['block' => true]); ?>
<div class="pages">

    <?php $this->Tabs->start(); ?>


    <?php
    $typeElement = 'Content.Admin/Pages/' . $page->type . '/manage';
    if ($page->type && $this->elementExists($typeElement)): ?>
        <?php $this->Tabs->add(__d('content', 'Page')); ?>
        <div><?php echo $this->element($typeElement, compact('page')); ?></div>
    <?php endif; ?>

    <?php $this->Tabs->add(__d('content', 'Edit')); ?>
        <?= $this->Form->create($page, ['novalidate' => 'novalidate', 'horizontal' => true]); ?>

                <?php
                echo $this->Form->input('type', [
                    'id' => 'select-type',
                    'disabled' => isset($page->type)
                    //'class' => 'select-ajax',
                    //'data-target' => 'select-type-params-form',
                    //'data-url' => ['action' => 'ajaxPageTypeForm']
                ]);
                ?>

                <?php
                echo $this->Form->input('parent_id',
                    ['options' => $pagesTree, 'empty' => '- Root Node -']);

                if ($page->parent_id) {
                    echo $this->Html->link(__d('content', 'Edit parent'), ['action' => 'edit', $page->parent_id]);
                }
                ?>
                <?php
                echo $this->Form->input('title');
                echo $this->Form->input('slug');
                ?>

                <?php
                $typeElement = 'Content.Admin/Pages/' . $page->type . '/form';
                ?>
                <?php if ($page->type && $this->elementExists($typeElement)): ?>
                    <div><?php echo $this->element($typeElement, compact('page')); ?></div>
                <?php endif; ?>

                <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Layout'), 'collapsed' => false]); ?>
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



                <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Publish'), 'collapsed' => false]); ?>
                <?php
                echo $this->Form->input('is_published');
                ?>
                <?php echo $this->Form->input('publish_start_date', ['type' => 'datepicker']); ?>
                <?php echo $this->Form->input('publish_end_date', ['type' => 'datepicker']); ?>
                <?= $this->Form->fieldsetEnd(); ?>



            <div class="actions text-right">
                <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'save btn btn-primary']) ?>
            </div>

        <?= $this->Form->end() ?>
        <!-- # -->



        <?php
            $this->Tabs->add(__d('content', 'Advanced'));
        ?>
        <?= $this->Form->create($page, ['novalidate' => 'novalidate', 'horizontal' => true]); ?>
        <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Navigation'), 'collapsed' => false]); ?>
        <?= $this->Form->input('hide_in_nav'); ?>
        <?= $this->Form->input('hide_in_sitemap'); ?>
        <?= $this->Form->fieldsetEnd(); ?>


        <?= $this->Form->fieldsetStart(['legend' => __d('content', 'DOM'), 'collapsed' => false]); ?>
        <?= $this->Form->input('cssid'); ?>
        <?= $this->Form->input('cssclass'); ?>
        <?= $this->Form->fieldsetEnd(); ?>



        <div class="actions">
            <?= $this->Form->button(__d('content','Save Changes'), ['class' => 'save btn btn-primary']) ?>
        </div>

        <?= $this->Form->end() ?>
        <!-- EOF PAGE EDIT FORM -->
        <?php debug($page); ?>


    <?php
    $this->Tabs->add(__d('content', 'Meta'), [
        'url' => ['action' => 'relatedPageMeta', $page->id]
    ]);

    $this->Tabs->add(__d('content', 'Related Modules'), [
        'url' => ['action' => 'relatedContentModules', $page->id]
    ]);

    $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]);
    debug($page);
    ?>

    <?php echo $this->Tabs->render(); ?>
</div>