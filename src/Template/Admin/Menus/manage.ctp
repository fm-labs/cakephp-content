<?php $this->Html->addCrumb(__('Menus'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__('Manage {0}', __('Menu'))); ?>
<?php $this->loadHelper('AdminLte.Box'); ?>
<?php $this->assign('heading', __('Manage {0}', __('Menu'))); ?>
<div class="form">

    <div class="row">
        <div class="col-md-3">

            <!-- Menus -->
            <div class="menus index">

                <?= $this->cell('Backend.DataTable', [[
                    'paginate' => false,
                    'model' => 'Content.Menus',
                    'data' => $menus,
                    'fields' => [
                        'site_id',
                        'title' => [
                            'formatter' => function($val, $row) {
                                return $this->Html->link($val, ['action' => 'manage', $row->id]);
                            }
                        ]
                    ],
                    'debug' => false,
                    'rowActions' => false
                ]]);
                ?>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <?php if ($menu): ?>
                <?= $this->Form->create($menu, ['class' => 'no-ajax']); ?>
                <?php echo $this->Form->input('title'); ?>
                <?= $this->Form->button(__('Change title')) ?>
                <?= $this->Form->end() ?>
                <?php echo $this->cell('Content.MenuModule::manage', [ $menu->id ]); ?>
            <?php endif; ?>

        </div>
        <div class="col-md-4">

            <?= $this->Html->css('Backend.jstree/themes/backend/style.min', ['block' => true]); ?>
            <?= $this->Html->script('Backend.jstree/jstree.min', ['block' => true]); ?>
            <?php
            $selected = $this->request->query('id');
            $dataUrl = $this->get('dataUrl', ['action' => 'treeData', $menu->id]);
            $sortUrl = $this->get('sortUrl', ['action' => 'treeSort']);

            $defaultJsTree = [
                'core' => [
                    'multiple' => false,
                    'data' => [
                        'url' => $this->Html->Url->build($dataUrl)
                    ],
                    'check_callback' => true,
                ],
                'plugins' => ['wholerow', 'state', 'dnd']
            ];
            $jsTree = $this->get('jsTree', $defaultJsTree);
            ?>
            <?= $this->Box->create('Menu'); ?>
            <?= $this->Html->div('be-index-tree', 'Loading ...', [
                'id' => 'index-tree',
                'data-url' => $this->Html->Url->build($dataUrl),
                'data-active' => $selected
            ]); ?>
            <?= $this->Box->render(); ?>
            <script>

                var sortUrl = '<?= $this->Html->Url->build($sortUrl) ?>';
                var jsTreeConf = jsTreeConf || JSON.parse('<?= json_encode($jsTree); ?>');

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
                                console.log('Selected: ' + r.join(', '));
                            }

                        }).on('move_node.jstree', function (e, data) {
                            console.log('Moved');
                            console.log(data);

                            var nodeId = data.node.id;

                            var oldParentId = data.old_parent;
                            var oldPosition = data.old_position;
                            var newParentId = data.parent;
                            var newPosition = data.position;

                            var oldParentNode = $tree.jstree(true).get_node(oldParentId);
                            var newParentNode = $tree.jstree(true).get_node(newParentId);



                            var postData = {
                                nodeId: nodeId,
                                oldParentId: (oldParentNode.data) ? oldParentNode.data.id : null,
                                oldPos: oldPosition,
                                newParentId: (newParentNode.data) ? newParentNode.data.id : null,
                                newPos: newPosition
                            };

                            console.log("Request", sortUrl, postData);

                            $.ajax({
                                url: sortUrl,
                                method: 'POST',
                                data: postData
                            }).done(function(response) {
                                console.log("Response", response);

                                // Update node data
                                console.log("Data Before", $tree.jstree(true).get_node(nodeId).data);
                                $tree.jstree(true).get_node(nodeId).data = response.node;
                                console.log("Data After", $tree.jstree(true).get_node(nodeId).data);

                            }).fail(function(error) {
                                console.error(error);
                            })

                        })

                        .jstree(jsTreeConf);

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
                            });
                });

            </script>
        </div>
        <div class="col-md-4">

            <?php if ($menu): ?>
                <?= $this->Box->create(__('Add {0}', __('Menu Item'))); ?>
                <?= $this->Form->create($newMenuItem, ['class' => '', 'url' => ['controller' => 'MenuItems', 'action' => 'add']]); ?>
                <?php
                echo $this->Form->hidden('menu_id', ['value' => $menu->id]);
                echo $this->Form->input('title');
                echo $this->Form->input('type');
                echo $this->Form->input('typeid');
                echo $this->Form->input('type_params');
                echo $this->Form->input('url');
                echo $this->Form->input('link_target');
                echo $this->Form->input('cssid');
                echo $this->Form->input('cssclass');
                echo $this->Form->input('hide_in_nav');
                echo $this->Form->input('hide_in_sitemap');
                ?>

                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
                <?= $this->Box->render(); ?>
            <?php else: ?>
                <?= __('Select a menu'); ?>
            <?php endif; ?>
        </div>
    </div>



</div>