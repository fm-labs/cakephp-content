<?php $this->loadHelper('Bootstrap.Tabs'); ?>
<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','Edit {0}', __d('content','Gallery'))); ?>
<?php $this->Toolbar->addPostLink(
    __d('content','Delete'),
    ['action' => 'delete', $gallery->id],
    ['data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $gallery->id)]
)
?>
<?php $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Galleries')),
    ['action' => 'index'],
    ['data-icon' => 'list']
) ?>


<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-image"></i>
        <strong><?= __d('content', 'Gallery'); ?></strong>
        <?= h($gallery->title); ?>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-8">
                &nbsp;
            </div>
            <div class="col-md-4">
                <div class="actions right grouped">
                    <ul>
                        <li><?= $this->Html->link(__d('content', 'Edit'),
                                [ 'action' => 'edit', $gallery->id ],
                                [ 'class' => 'edit link-frame-modal btn btn-primary btn-sm', 'data-icon' => 'edit']);
                            ?>
                        </li>
                        <li><?= $this->Html->link(__d('content', 'Delete'),
                                [ 'action' => 'delete', $gallery->id ],
                                [ 'class' => 'delete btn btn-danger btn-sm',
                                    'data-icon' => 'trash-o',
                                    'confirm' => __d('content', 'Sure ?'),
                                ]);
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?= $this->Tabs->start(); ?>
        <?php
        $this->Tabs->add(__d('content', 'Gallery'), [
            'url' => ['action' => 'view', $gallery->id]
        ]);
        ?>

        <?php
        $this->Tabs->add(__d('content', 'Pages'), [
            //'url' => ['action' => 'relatedPages', $content->id]
        ]);
        ?>

        <div class="related">
            <?= $this->cell('Admin.DataTable', [[
                'paginate' => false,
                'model' => 'Content.Pages',
                'data' => isset($galleryPages) ? $galleryPages : [],
                'sortable' => true,
                'sortUrl' => ['plugin' => 'Content', 'controller' => 'Sort', 'action' => 'tableSort'],
                'fields' => [
                    'id',
                    'pos',
                    'is_published' => [
                        'title' => __d('content', 'Published'),
                        'formatter' => function($val, $row) {
                            return $this->Ui->statusLabel($val);
                        }
                    ],
                    'created',
                    'image_file' => [
                        'formatter' => function($val) {
                            if (!$val) {
                                return "";
                            }
                            return $this->Html->image($val->url, ['width' => 50]);
                        }
                    ],
                    'title' => [
                        'formatter' => function($val, $row) {
                            return $this->Html->link($val, ['action' => 'edit', $row->id]);
                        }
                    ],
                ],
                'rowActions' => [
                    [__d('content','Edit'), ['action' => 'edit', ':id'], ['class' => 'edit link-frame-modal']],
                    [__d('content','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('content','Are you sure you want to delete # {0}?', ':id')]]
                ]
            ]]);
            ?>
            <div class="actions">
                <?= $this->Ui->link(__d('content','Add Gallery Item'),
                    ['action' => 'addItem', $gallery->id],
                    ['class' => 'btn btn-default link-frame-modal', 'data-icon' => 'plus']
                ) ?>

                <?= $this->Html->link(
                    __d('content', 'Reorder (asc)'),
                    [
                        'plugin' => 'Admin', 'controller' => 'DataTable', 'action' => 'reorder', 'model' => 'Content.Pages',
                        'field' => 'pos',  'order' => 'asc',
                        'scope' => ['refscope' => 'Content.Galleries', 'refid' => $gallery->id]
                    ],
                    ['class' => 'link-frame btn'],
                    __d('content', 'Are you sure?')); ?>
                <?= $this->Html->link(
                    __d('content', 'Reorder (desc)'),
                    [
                        'plugin' => 'Admin', 'controller' => 'DataTable', 'action' => 'reorder', 'model' => 'Content.Pages',
                        'field' => 'pos',  'order' => 'desc',
                        'scope' => ['refscope' => 'Content.Galleries', 'refid' => $gallery->id]
                    ],
                    ['class' => 'link-frame btn'],
                    __d('content', 'Are you sure?')); ?>
            </div>


        </div>


        <?php $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]); ?>
        <?php debug($gallery); ?>

        <?= $this->Tabs->render(); ?>
    </div>
</div>

