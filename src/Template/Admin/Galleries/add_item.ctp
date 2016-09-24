<?php $this->Html->addCrumb(__d('content','Galleries'), ['action' => 'index']); ?>
<?php $this->Html->addCrumb(__d('content','New {0}', __d('content','Gallery Item'))); ?>
<div class="posts">
    <?= $this->Form->create($item); ?>
    <div class="users ui top attached segment">
        <div class="ui form">
        <?php
            echo $this->Form->input('refscope', ['default' => 'Content.Galleries']);
            echo $this->Form->input('refid');
            echo $this->Form->input('title');
            echo $this->Form->input('image_file', ['type' => 'imageselect', 'options' => '@default']);
            echo $this->Form->input('body_html', ['type' => 'htmleditor']);
            echo $this->Form->hidden('is_published', ['default' => 1]);
        ?>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <?= $this->Form->button(__d('content','Continue')) ?>
    </div>
    <?= $this->Form->end() ?>

</div>