<?php
echo $this->element(
    $element_path, [
        'class' => $class,
        'menu' => $menu,
        'level' => $level,
        'element' => $element_path
    ]
);