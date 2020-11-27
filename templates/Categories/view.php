<div class="category view">

    <!--
    <h1 class="title"><?= h($category->name); ?></h1>
    -->

    <div class="posts">
        <?php foreach($pages as $page): ?>
            <?= $this->element('Content.Pages/request_teaser', ['post' => $page]); ?>
        <?php endforeach; ?>
    </div>
</div>

<?php debug($category); ?>
<?php debug($pages); ?>
