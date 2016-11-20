<?php $this->loadHelper('Bootstrap.Panel'); ?>
<div class="contents form">

    <?= $this->Panel->create(); ?>

    <?php if ($this->fetch('heading')): ?>
    <?= $this->Panel->heading(); ?>
    <?= $this->fetch('heading', "[No heading]"); ?>
    <?php endif; ?>

    <?= $this->Panel->body(); ?>
    <?= $this->fetch('content'); ?>

    <?= $this->Panel->render(); ?>
</div>