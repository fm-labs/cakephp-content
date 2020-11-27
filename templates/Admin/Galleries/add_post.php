<?php
$this->loadHelper('Media.Media');
?>
<?php $this->Breadcrumbs->add(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Breadcrumbs->add(__d('content','New {0}', __d('content','Gallery Page'))); ?>
<?php
$this->assign('title', __d('content', 'Galleries'));
$this->assign('heading', $gallery->title);
$this->assign('subheading', 'New gallery post');
?>
<div class="posts">
    <?= $this->Form->create($page); ?>
    <div class="ui form">
        <?php
        echo $this->Form->control('title');
        echo $this->Form->hidden('refscope', ['default' => 'Content.Galleries']);
        echo $this->Form->hidden('refid');
        echo $this->Form->hidden('is_published', ['default' => 0]);
        ?>
    </div>
    <div class="actions">
        <?= $this->Form->button(__d('content','Continue'), ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $this->Form->end() ?>
</div>
