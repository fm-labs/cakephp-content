<div class="view">
    <article class="post <?= $post->cssclass; ?>" id="<?= $post->cssid ?>">
        <h1 class="title">
            <?= h($post->title); ?>
        </h1>
        <div class="image">
            <?php if ($post->image): ?>
                <?= $this->Html->image($post->image->url); ?>
            <?php endif; ?>
        </div>
        <div class="body">
            <?= $this->Content->userHtml($post->body_html); ?>
        </div>
    </article>


    <div class="post-info well">
        <?php
        $postInfo = [
            ['label' => __('Perma Url'), 'data' => $post->getPermaUrl()]
        ]
        ?>
        <p>
            <span class="post-info-title">Canonical URL</span>
            <span class="post-info-data"><?= $this->Html->link($post->getViewUrl()); ?></span>
        </p>
        <p>
            <span class="post-info-title">Perma URL</span>
            <span class="post-info-data"><?= $this->Html->link($post->getPermaUrl()); ?></span>
        </p>
    </div>
</div>