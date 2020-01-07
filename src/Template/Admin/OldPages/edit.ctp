<?php
use Cake\Utility\Inflector;

$this->loadHelper('Bootstrap.Panel');
$this->loadHelper('Bootstrap.Tabs');
//$this->extend('Backend./Admin/Action/edit');

// EXTEND: TOOLBAR
/*
$this->Toolbar->addLink(__d('content','New {0}', __d('content','Page')), ['action' => 'add'], ['data-icon' => 'plus']);
$this->Toolbar->addLink(__d('content','All {0}', __d('content','Pages')), ['action' => 'index'], ['data-icon' => 'list']);
$this->Toolbar->addLink(__d('content','Preview'), ['action' => 'preview', $page->id], ['data-icon' => 'eye', 'target' => '_preview']);
$this->Toolbar->addLink(__d('content','Info', __d('content','Info')), ['action' => 'info', $page->id], ['data-icon' => 'info']);
$this->Toolbar->addLink(
    __d('content','Delete'),
    ['action' => 'delete', $page->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $page->id)]
);


*/

// LEFT
//$this->loadHelper('Bootstrap.Menu');

/*
$this->start('left');

$menu = \Cake\ORM\TableRegistry::get('Content.Pages')->getMenu(null, ['includeHidden' => true]);
echo $this->Menu->create(['items' => $menu])
    ->setUrlCallback(function($page) { return ['action' => 'edit', $page['data-id'] ]; })
    ->render();

$this->end();
*/

// CONTENT
// HEADING
$this->assign('title', $page->title);
//$this->assign('heading', $page->title);
$this->Breadcrumbs->add(__d('content', 'Pages'), ['action' => 'index']);
$this->Breadcrumbs->add($page->title);
?>
<?php $this->Html->script('/backend/libs/jquery-ui/jquery-ui.min.js', ['block' => true]); ?>
<div class="form">
    <?= $this->Form->create($page, ['novalidate' => 'novalidate', 'horizontal' => true]); ?>

    <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Page'), 'collapsed' => false]); ?>
    <?= $this->Form->input('title'); ?>

    <?php
    // page type specific form input injection via elements
    $typeElement = 'Content.Admin/Pages/' . $page->type . '/form';
    if ($page->type && $this->elementExists($typeElement)) {
        //echo $this->Form->fieldsetStart(['legend' => __d('content', $page->type), 'collapsed' => false]);
        echo $this->Html->div('', $this->element($typeElement, compact('page')));
        //echo $this->Form->fieldsetEnd();
    }
    ?>
    <?= $this->Form->fieldsetEnd(); ?>

    <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Advanced'), 'collapsed' => false]); ?>
        <?php
        echo $this->Form->input('type', [
            'id' => 'select-type',
            'disabled' => isset($page->type),
            'default' => 'content',
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
        echo $this->Form->input('slug');
        ?>

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

        <?= $this->Form->input('hide_in_nav'); ?>
        <?= $this->Form->input('hide_in_sitemap'); ?>
        <?= $this->Form->input('cssid'); ?>
        <?= $this->Form->input('cssclass'); ?>

    <?= $this->Form->fieldsetEnd(); ?>


    <?= $this->Form->submit(__d('content','Save Changes'), ['class' => 'save btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <!-- EOF PAGE EDIT FORM -->

    <div>

        <?php
        // page type specific form input injection via elements
        $typeElement = 'Content.Admin/Pages/' . $page->type . '/related';
        if ($page->type && $this->elementExists($typeElement)) {
            //echo $this->Form->fieldsetStart(['legend' => __d('content', $page->type), 'collapsed' => false]);
            echo $this->Html->div('', $this->element($typeElement, compact('page')));
            //echo $this->Form->fieldsetEnd();
        }
        ?>
    </div>
    <?php debug($page); ?>

</div>
