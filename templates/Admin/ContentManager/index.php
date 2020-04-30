<?php
$this->assign('title', 'Content Manager');
$this->loadHelper('Bootstrap.Menu');
$this->loadHelper('Admin.Box');
?>
<div class="index content-manager">

    <?php $this->Box->create('Hello World'); ?>
    This is awesome!
    <?php echo $this->Box->render(); ?>

    <?php echo $this->Menu->create($this->get('menu'))->render(); ?>

    <?php debug($menu); ?>
</div>

<?php $this->append('script-bottom'); ?>
<script>
$(document).ready(function() {
    /*
    $('.tabular.menu .item').tab({
        auto: true,
        path: '<?= $this->Url->build(['controller' => 'ContentManager', 'action' => 'tab']); ?>'
    });
    */
});
</script>
<?php $this->end();