<?php
debug($moduleName);

//debug($pm);
$cell = $this->cell('Content.ModuleRenderer::named', ['moduleName' => $moduleName, 'template' => $moduleTemplate]);
//$cell->template = $pm->template;
echo $cell;
