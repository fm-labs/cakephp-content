<?php $this->loadHelper('Bootstrap.Tabs'); ?>
<?php $this->loadHelper('AdminLte.Box'); ?>
<div class="galleries index">

    <!-- Galleries select -->
    <?= $this->Form->create(null, ['method' => 'GET']); ?>
    <?= $this->Form->input('id', ['label' => false, 'options' => $galleryTree, 'val' => (isset($gallery)) ? $gallery->id : null]); ?>
    <?= $this->Form->button(__('Edit Gallery')); ?>
    <?= $this->Form->end(); ?>

    <!-- Gallery edit area -->
    <?php if (isset($gallery)): ?>
        <hr />
        <?= $this->Tabs->create(); ?>
        <?= $this->Tabs->add('Gallery'); ?>
        <div class="gallery form row">
            <div class="col-md-9">

                <?= $this->Form->create($gallery, ['url' => ['action' => 'edit', $gallery->id]]); ?>
                <?php
                echo $this->Form->input('title');
                echo $this->Form->input('parent_id', ['empty' => __('No parent')]);
                echo $this->Form->input('inherit_desc', ['label' => 'Inherit description from parent']);
                echo $this->Form->input('desc_html', [
                    'type' => 'htmleditor',
                    'editor' => [
                        'image_list_url' => '@Content.HtmlEditor.default.imageList',
                        'link_list_url' => '@Content.HtmlEditor.default.linkList'
                    ]
                ]);
                echo $this->Form->input('view_template');
                echo $this->Form->input('source', ['empty' => true]);
                echo $this->Form->input('source_folder', ['empty' => true]);
                ?>
                <?= $this->Form->button(__d('content','Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
            <div class="col-md-3">
                <?= $this->Box->create(__('Linked modules')); ?>
                <ul class="nav nav-default nav-pills nav-stacked">
                    This gallery is used by <strong><?= h((int)count($modules)); ?></strong> modules:
                <?php foreach ($modules as $module): ?>
                    <li role="presentation"><?= $this->Html->link($module['name'], ['controller' => 'ModuleBuilder', 'action' => 'build', $module->id]); ?></li>
                <?php endforeach; ?>
                </ul>
                <hr />
                <?= $this->Html->link(__('Create slider for this gallery'),
                    ['controller' => 'ModuleBuilder', 'action' => 'build', 'path' => 'Content.Flexslider', 'gallery_id' => $gallery->id, 'name' => 'Mod ' . $gallery->title],
                    ['class' => 'btn btn-default']); ?>
                <?= $this->Box->render(); ?>
            </div>


        </div>

        <?php
        if ($gallery->source == "posts"):
        $this->Tabs->add(__d('content', 'Posts'), []);
        ?>

        <div class="related">
            <?= $this->cell('Backend.DataTable', [[
                'paginate' => false,
                'model' => 'Content.Posts',
                'data' => isset($galleryPosts) ? $galleryPosts : [],
                'sortable' => true,
                'sortUrl' => ['plugin' => 'Content', 'controller' => 'Sort', 'action' => 'tableSort'],
                'fields' => [
                    //'id',
                    //'pos',
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
                            return $this->Html->link($val, ['controller' => 'Galleries', 'action' => 'edit_post', $row->id]);
                        }
                    ],
                    'is_published' => [
                        'title' => __d('content', 'Published'),
                        'formatter' => function($val, $row) {
                            return $this->Ui->statusLabel($val);
                        }
                    ],
                    'created',
                ],
                'rowActions' => [
                    [__d('shop','Edit'), ['action' => 'edit_post', ':id'], ['class' => 'edit']],
                    [__d('shop','Delete'), ['action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
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
                        'controller' => 'Sort', 'action' => 'reorder', 'model' => 'Content.Posts',
                        'field' => 'pos',  'order' => 'asc',
                        'scope' => ['refscope' => 'Content.Galleries', 'refid' => $gallery->id]
                    ],
                    ['class' => 'link-frame btn btn-default']); ?>
                <?= $this->Html->link(
                    __d('content', 'Reorder (desc)'),
                    [
                        'controller' => 'Sort', 'action' => 'reorder', 'model' => 'Content.Posts',
                        'field' => 'pos',  'order' => 'desc',
                        'scope' => ['refscope' => 'Content.Galleries', 'refid' => $gallery->id]
                    ],
                    ['class' => 'link-frame btn btn-default']); ?>
            </div>


        </div>
        <?php endif; ?>


        <?php $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]); ?>
        <?php debug($gallery); ?>

        <?= $this->Tabs->render(); ?>
    <?php endif; ?>

</div>