<?php
$this->Breadcrumbs->add(__('Module Builder'), ['action' => 'index']);

$this->assign('title', __('Module Builder'));
?>
<div class="index">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Module</th>
            <th>Actions</th>
        </tr>
        </thead>
        <?php foreach ($availableModules as $moduleClass => $moduleInfo): ?>
            <tr>
                <td><?= h($moduleClass); ?></td>
                <td class="actions">
                    <?= $this->Html->link('Create new module', [
                        'action' => 'build',
                        'path' => $moduleInfo['class'],
                    ], ['class' => 'btn btn-sm btn-default']); ?>
                    <!--
                    <?= $this->Html->link('View', ['action' => 'view', 'class' => $moduleInfo['class']]); ?>
                    -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>