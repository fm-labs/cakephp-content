<div class="upload form">
    <h4 class="ui top attached header">Primary Image</h4>
    <div class="ui attached segment">
        <?= $this->Form->create($content, ['type' => 'file']); ?>
        <?php

        if ($content->image_file) {
            echo h($content->image_file) . '<br />';
            echo $this->Html->image($content->image_file->url, ['width' => 200]);
        }
        echo $this->Form->control('image_file_upload', ['type' => 'file', 'label' => false]);

        //$this->Form->addWidget('upload', ['Content\\View\\Widget\\UploadWidget', 'html', 'form']);
        //echo $this->Form->control('image_upload', ['type' => 'upload']);
        ?>
        <?= $this->Form->button(__d('content','Upload image')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>