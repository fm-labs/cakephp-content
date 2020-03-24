<div class="category view">

    <!--
    <h1 class="title"><?= h($category->name); ?></h1>
    -->

    <div class="posts">
        <?php foreach($articles as $article): ?>
            <?= $this->element('Content.Articles/request_teaser', ['post' => $article]); ?>
        <?php endforeach; ?>
    </div>
</div>

<?php debug($category); ?>
<?php debug($articles); ?>
