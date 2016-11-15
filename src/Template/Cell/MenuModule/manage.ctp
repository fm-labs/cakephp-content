<?php $this->loadHelper('Bootstrap.Nav'); ?>
<?php echo $this->Nav->create([
    'class' => $params['class'],
    'items' => $params['menu'],
    'trail' => false,
    'active' => false
])->render(); ?>