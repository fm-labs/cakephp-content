<?php $this->Html->addCrumb(__d('content','Posts'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb($post->title); ?>
<?= $this->Toolbar->addLink(
    __d('content','Edit {0}', __d('content','Post')),
    ['action' => 'edit', $post->id],
    ['class' => 'item', 'data-icon' => 'edit']
) ?>
<?= $this->Toolbar->addPostLink(
    __d('content','Delete {0}', __d('content','Post')),
    ['action' => 'delete', $post->id],
    ['class' => 'item', 'data-icon' => 'trash', 'confirm' => __d('content','Are you sure you want to delete # {0}?', $post->id)]) ?>

<?= $this->Toolbar->addLink(
    __d('content','List {0}', __d('content','Posts')),
    ['action' => 'index'],
    ['class' => 'item', 'data-icon' => 'list']
) ?>
<?= $this->Toolbar->addLink(
    __d('content','New {0}', __d('content','Post')),
    ['action' => 'add'],
    ['class' => 'item', 'data-icon' => 'plus']
) ?>

<div class="posts view">

    <?= $this->cell('Backend.EntityView', [ $post ], [
        'title' => $post->title,
        'model' => 'Content.Posts',
        'fields' => [
            'title' => [
                'formatter' => function($val, $entity) {
                    return $this->Html->link($val, ['action' => 'edit', $entity->id]);
                }
            ],
            'is_published' => ['formatter' => 'boolean'],
            'url' => ['formatter' => 'link']
        ],
        'exclude' => ['meta', 'content_modules']
    ]); ?>

</div>
