<?php $this->loadHelper('Bootstrap.Panel'); ?>
<div class="contents form">

    <?= $this->Panel->create(); ?>
    <?= $this->Panel->heading(); ?>
    <span class="strong"><i class="fa fa-pencil"></i> Edit</span>
    <?= $this->fetch('heading', "[No heading]"); ?>

    <?= $this->Panel->body(); ?>
    <?= $this->fetch('content'); ?>

    <?= $this->Panel->render(); ?>
</div>