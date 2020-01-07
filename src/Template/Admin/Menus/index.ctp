<?php $this->loadHelper('Bootstrap.Menu'); ?>
<?php $this->loadHelper('Backend.Toolbar'); ?>
<?php
$this->Toolbar->addLink("Add", ['action' => 'index', 'add' => 1]);
$this->Toolbar->addLink("Tree Sort", ['action' => 'sort']);
?>
<style>
    .menu-tree-items {
        border: 1px dashed green;
        margin-left: 2em;
    }
    .menu-tree-item-wrap {
        border: 1px dashed blue;
    }
    .menu-tree-item {
        border: 1px solid red;
        padding: 1em;
        margin-bottom: 0.5em;
    }
</style>
<div>
    <div class="row">
        <div class="col-md-4">
            <?= $this->element('Content.Admin/Menus/tree_form', ['items' => $menusThreaded]); ?>
        </div>
        <div class="col-md-8">

            <?php
            if (isset($menu)) :
                /* @var \Banana\Menu\Menu $menu */
                echo $this->Menu->create([
                    'items' => $menu->getItems()
                ])->render();
            endif;
            ?>

            <?php if (isset($menuItem)) : ?>

                <div class="form">
                    <?= $this->Form->create($menuItem); ?>
                    <?= $this->Form->hidden('id'); ?>
                    <?= $this->Form->hidden('lft'); ?>
                    <?= $this->Form->hidden('rght'); ?>
                    <?= $this->Form->hidden('level'); ?>

                    <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Menu Item'), 'collapsed' => false]); ?>
                    <?= $this->Form->input('parent_id', ['empty' => true, 'options' => $menuTreeList]); ?>
                    <?= $this->Form->input('title'); ?>
                    <?= $this->Form->input('type', ['options' => $this->get('menuTypes')]); ?>
                    <?= $this->Form->fieldsetEnd(); ?>

                    <?= $this->Form->fieldsetStart(['legend' => \Cake\Utility\Inflector::humanize($menuItem->type), 'collapsed' => false]); ?>
                    <?php
                    // page type specific form input injection via elements
                    $typeElement = 'Content.Admin/Menus/' . $menuItem->type . '/form';
                    if ($menuItem->type && $this->elementExists($typeElement)) {
                        //echo $this->Form->fieldsetStart(['legend' => __d('content', $page->type), 'collapsed' => false]);
                        echo $this->Html->div('', $this->element($typeElement, ['page' => $menuItem]));
                        //echo $this->Form->fieldsetEnd();
                    }
                    ?>
                    <?= $this->Form->fieldsetEnd(); ?>

                    <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Advanced'), 'collapsed' => false]); ?>
                    <?= $this->Form->input('cssid'); ?>
                    <?= $this->Form->input('cssclass'); ?>
                    <?= $this->Form->input('hide_in_nav'); ?>
                    <?= $this->Form->input('hide_in_sitemap'); ?>
                    <?= $this->Form->fieldsetEnd(); ?>

                    <?= $this->Form->fieldsetStart(['legend' => __d('content', 'Legacy'), 'collapsed' => true]); ?>
                    <?= $this->Form->input('redirect_location'); ?>
                    <?= $this->Form->input('redirect_controller'); ?>
                    <?= $this->Form->input('redirect_page_id', ['type' => 'text']); ?>
                    <?= $this->Form->input('redirect_status'); ?>
                    <?= $this->Form->input('slug'); ?>
                    <?= $this->Form->fieldsetEnd(); ?>

                    <?= $this->Form->submit(); ?>
                    <?= $this->Form->end(); ?>
                </div>

            <?php endif; ?>
        </div>
    </div>


</div>
<?php $this->append('script'); ?>
<script>
    $('.menu-tree-item-wrap[draggable=true]')
        .on('dragstart', function(ev) {
            console.log("dragstart", ev.target.id, ev);
            ev.originalEvent.dataTransfer.setData("text", ev.target.id);
            $(ev.target).css({"background-color": "blue"});
        })
        .on('dragend', function(ev) {
            console.log("dragend", ev.target.id, ev);
            $(ev.target).css({"background-color": "transparent"});
        })
        .on('dragover', function(ev) {
            console.log("dragover", ev.originalEvent.target.id, ev);
            var data = ev.originalEvent.dataTransfer.getData("text");
            console.log("dragover data", data);
            ev.preventDefault();
        })
        .on('drop', function(ev) {
            console.log("drop", ev.originalEvent.target.id, ev);
            ev.preventDefault();
            var data = ev.originalEvent.dataTransfer.getData("text");
            console.log("drop data", data);

            var $target;
            if (ev.target.className != "menu-tree-item-wrap") {
                $target = $(ev.target).closest('.menu-tree-item-wrap');
            } else {
                $target = $(ev.target);
            }

            console.log("drop target", $target);
            $('#' + data).insertBefore($target);

            //ev.originalEvent.target.appendChild(document.getElementById(data));
        });
</script>
<?php $this->end(); ?>