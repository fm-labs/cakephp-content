<?php $this->loadHelper('Content.Content'); ?>
<div class="related posts">

    <?php if (count($posts) < 1): ?>
    No posts found
    <?php endif; ?>

    <!--
    <div class="actions">
        <?= $this->Html->link(__('Sortieren'), ['plugin' => 'Backend', 'controller' => 'DataTable', 'action' => 'sort', 'model' => 'Content.Posts', 'refscope' => 'Content.Pages', 'refid' => $content->id]); ?>
    </div>
    -->

    <?= $this->cell('Backend.DataTable', [[
        'paginate' => false,
        'sortable' => true,
        'sortUrl' => ['plugin' => 'Content', 'controller' => 'Sort', 'action' => 'tableSort'],
        'model' => 'Content.Posts',
        'data' => $posts,
        'fields' => [
            'pos',
            'is_published' => [
                'title' => __d('content', 'Published'),
                'formatter' => function($val, $row) {
                    return $this->Ui->statusLabel($val);
                }
            ],
            'title' => [
                'formatter' => function($val, $row) {
                    return $this->Html->link($val, ['controller' => 'Posts', 'action' => 'edit', $row->id]);
                }
            ]
        ],
        'rowActions' => [
            [__d('shop','Edit'), ['controller' => 'Posts', 'action' => 'edit', ':id'], ['class' => 'edit']],
            //[__d('shop','Move Up'), ['controller' => 'Posts', 'action' => 'moveUp', ':id'], ['class' => 'move up']],
            //[__d('shop','Move Down'), ['controller' => 'Posts', 'action' => 'moveDown', ':id'], ['class' => 'move down']],
            [__d('shop','Delete'), ['controller' => 'Posts', 'action' => 'delete', ':id'], ['class' => 'delete', 'confirm' => __d('shop','Are you sure you want to delete # {0}?', ':id')]]
        ]
    ]]);
    ?>

    <div class="actions grouped">
        <ul>
            <li><?= $this->Html->link(
                    __d('content', 'Add {0}', __d('content', 'Post')),
                    ['controller' => 'Posts', 'action' => 'add', 'refscope' => 'Content.Pages',  'refid' => $content->id],
                    ['class' => 'link-frame btn btn-default']); ?>
            </li>
            <li><?= $this->Html->link(
                    __d('content', 'Reorder (asc)'),
                    [
                        'controller' => 'Sort', 'action' => 'reorder', 'model' => 'Content.Posts',
                        'field' => 'pos',  'order' => 'asc',
                        'scope' => ['refscope' => 'Content.Pages', 'refid' => $content->id]
                    ],
                    ['class' => 'link-frame btn btn-default']); ?></li>
            <li><?= $this->Html->link(
                    __d('content', 'Reorder (desc)'),
                    [
                        'controller' => 'Sort', 'action' => 'reorder', 'model' => 'Content.Posts',
                        'field' => 'pos',  'order' => 'desc',
                        'scope' => ['refscope' => 'Content.Pages', 'refid' => $content->id]
                    ],
                    ['class' => 'link-frame btn btn-default']); ?>
            </li>
        </ul>
    </div>

    <?php //debug($posts); ?>
</div>