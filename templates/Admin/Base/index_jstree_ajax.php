<?php
/**
 * Extendable HTML view template
 * A two-column template using jsTree as tree navigation and triggers jquery's ajax
 * to load html contents into the content column
 *
 * ---
 * Inject custom jsTree json config from the extending template
 * Example script, which can be inserted in the extending template:
 * <?php $this->start('jsTreeScript'); ?>
 * <script>
 * jsTreeConf = {
 *  core: {
 *    data: {
 *      data: function(node) {
 *        return { 'id': node.id };
 *      }
 *    }
 *  }
 * }
 * </script>
 * <?php $this->end(); ?>
 *
 *
 * Parameters:
 * @param dataUrl string Url to fetch tree data json
 * @param viewUrl string Url to fetch tree node content
 * @param jsTree array jsTree params. See jsTree documentation for options
 * @link https://www.jstree.com/
 */
$selected = $this->request->getQuery('id');
$dataUrl = $this->get('dataUrl', ['action' => 'treeData']);
$viewUrl = $this->get('viewUrl', ['action' => 'treeView']);


$defaultJsTree = [
    'core' => [
        'multiple' => false,
        'data' => [
            'url' => $this->Html->Url->build($dataUrl)
        ],
        'check_callback' => true,
    ],
    'plugins' => ['wholerow', 'state']
];
$jsTree = $this->get('jsTree', $defaultJsTree);
?>
<?= $this->Html->css('/admin/css/jstree/themes/admin/style.min', ['block' => true]); ?>
<?= $this->Html->script('/admin/libs/jstree/jstree.min', ['block' => true]); ?>
<div class="index index-tree">
    <?php if ($this->fetch('heading')): ?>
        <div class="page-heading">
            <h1><?= $this->fetch('heading'); ?></h1>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-4 col-md-3">
            <div class="panel panel-primary panel-nopad no-border">
                <?php if ($this->fetch('treeHeading')): ?>
                <div class="panel-heading">
                    <?= $this->fetch('treeHeading'); ?>
                </div>
                <?php endif; ?>

                <div class="panel-body">
                    <?= $this->Html->div('be-index-tree', 'Loading ...', [
                        'id' => 'index-tree',
                        'data-url' => $this->Html->Url->build($dataUrl),
                        'data-active' => $selected
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-8 col-md-9">
            <div id="index-tree-container">
                <?= $this->fetch('content'); ?>
            </div>
        </div>
    </div>

    <div id="index-tree-noview" style="display: none">
        <?= $this->fetch('noview', '<div class="alert alert-info">Nothing found</div>'); ?>
    </div>

</div>
<script>
    var jsTreeConf;
</script>
<?php
// Custom jstree config injection from 'jsTreeScript' block
echo $this->fetch('jsTreeScript');
?>
<script>

    jsTreeConf = jsTreeConf || JSON.parse('<?= json_encode($jsTree); ?>');

    if (!jsTreeConf.core || !jsTreeConf.data || !jsTreeConf.data.data) {
        jsTreeConf.core.data.data = function (node) {
            return {'id': node.id};
        };
    }


    $(document).ready(function() {

        var selected = {};
        var path;
        var $tree = $('#index-tree');
        var $container = $('#index-tree-container');
        var $noview = $('#index-tree-noview');

        $.jstree.defaults.checkbox.three_state = false;
        $.jstree.defaults.checkbox.cascade = 'up+undetermined';

        $.jstree.defaults.dnd.is_draggable = function() { return true; };

        $tree
            .on('ready.jstree', function(e) {
                var selected = $tree.data('active');

                if (selected) {
                    $tree.jstree('deselect_all', true);
                    $tree.jstree('select_node', [selected], false, false);

                }
            })
            .on('changed.jstree', function (e, data) {
                var i, j, r = [];
                //console.log(data);
                if (data.action === "select_node") {
                    for(i = 0, j = data.selected.length; i < j; i++) {
                        r.push(data.instance.get_node(data.selected[i]).id);
                    }

                    //console.log('Selected: ' + r.join(', '));

                    var config = '';
                    //var url = $tree.data('viewUrl') + '?id=' + r.join(',');
                    var url = data.node.data.viewUrl;

                    if (url) {

                        Admin.Ajax.loadHtml($container, url, {
                            data: {'selected': r },
                        }).always(function(ev) {

                            if (!!window.history) {
                                if (history.state && history.state.selected && _.isEqual(history.state.selected, r)) {
                                    console.log("ReplaceState!");
                                    history.replaceState({ context: 'tree', selected: r}, '', url);
                                } else {
                                    console.log("PushState");
                                    history.pushState({ context: 'tree', selected: r}, '', url);
                                }
                            }

                        });
                    }

                }

            })

            .jstree(jsTreeConf);

        /*
         .on('move_node.jstree', function (e, data) {
         console.log('Moved');
         console.log(data);

         var movedId = data.node.id;

         var movedB
         });
         */

        /*
         $(document)

         .on('dnd_scroll.vakata', function (e, data) {
         console.log("dnd_scroll");
         console.log(data);
         })


         .on('dnd_start.vakata', function (e, data) {
         console.log("dnd_start");
         console.log(data);
         })

         .on('dnd_stop.vakata', function (e, data) {
         console.log("dnd_stop");
         console.log(data);
         })
         */

        $(window).on('popstate', function(ev) {
            var state = ev.originalEvent.state;
            console.log("Popstate! ", location.href, state, ev);

            if (state !== null && state.context && state.context === "tree") {

                $tree.jstree('deselect_all', true);
                $tree.jstree('select_node', state.selected);

                ev.stopPropagation();
            }

        });
    });

</script>