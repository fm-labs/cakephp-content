<div class="content-modules-section-editable">
    <h4><?= $section; ?></h4>
    <?php if (!empty($contentModules)): ?>
    <?php foreach ($contentModules as $contentModule): ?>
        <?php $module = $contentModule->module; ?>
        <?php if ($contentModule->section != $section) continue; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                [<?= h($contentModule->section); ?>]
                [<?= h($module->path); ?>]
                <?= h($module->name); ?>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach($module->params_arr as $k => $v): ?>
                        <li><?= h($k) ?>:<?= (is_array($v)) ? '[Array]' : $v; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="panel-footer">
                <?= $this->Ui->link('Edit Module', [
                    'plugin' => 'Content',
                    'controller' => 'ModuleBuilder',
                    'action' => 'edit',
                    $module->id,
                    'refscope' => $contentModule->refscope,
                    'refid' => $contentModule->refid
                ], ['data-icon' => 'edit', 'target' => '_blank']); ?> |

                <?= $this->Ui->link('Edit Content Module',
                    ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'edit', $contentModule->id ],
                    ['data-icon' => 'edit', 'target' => '_blank']); ?>
                <?= $this->Ui->link('Remove Content Module',
                    ['plugin' => 'Content',  'controller' => 'ContentModules', 'action' => 'delete', $contentModule->id ],
                    ['data-icon' => 'trash']); ?>
            </div>
        </div>
    <?php endforeach; ?>

        <div class="form">
            <?= $this->Form->create(null, ['idPrefix' => $section, 'url' => ['action' => 'linkModule', $content->id]]); ?>
            <?= $this->Form->hidden('refscope', ['default' => 'Content.Pages']); ?>
            <?= $this->Form->hidden('refid', ['default' => $content->id]); ?>
            <?= $this->Form->input('module_id', ['options' => $availableModules, 'label' => false]); ?>
            <?= $this->Form->input('section', ['type' => 'hidden', 'value' => $section]); ?>
            <?= $this->Form->button('Add module'); ?>
            <?= $this->Form->end(); ?>
        </div>
    <?php endif; ?>
</div>

