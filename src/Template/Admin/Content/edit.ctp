<?php $this->loadHelper('Bootstrap.Panel'); ?>
<div class="contents form">

    <?php if ($this->fetch('heading')): ?>
        <h2>
            <span class="strong"><i class="fa fa-pencil"></i></span>
            <?= $this->fetch('heading'); ?>
        </h2>
    <?php endif; ?>

    <?php echo $this->fetch('content'); ?>
</div>