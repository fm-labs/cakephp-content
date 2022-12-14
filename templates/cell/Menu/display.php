<?php
$menu = $this->get('menu');
$elementPath = $this->get('element_path');
if (!$elementPath) {
    echo "Can not display menu: Element path missing";
    return;
}
echo $this->element($elementPath, ['menu' => $menu]);
