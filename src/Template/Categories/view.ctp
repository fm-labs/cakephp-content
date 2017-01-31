<div class="category view">

    <!--
    <h1 class="title"><?= h($category->name); ?></h1>
    -->

    <div class="posts">
        <?php foreach($posts as $post): ?>
            <?= $this->element('Content.Posts/request_teaser', ['post' => $post]); ?>
        <?php endforeach; ?>
    </div>
</div>

<?php debug($category); ?>
<?php debug($posts); ?>
