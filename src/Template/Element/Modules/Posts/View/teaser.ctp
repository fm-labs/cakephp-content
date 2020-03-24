<?php
/**
 * @param View $this
 */

use Cake\View\View;

if (!$article) {
    echo '<div class="mod-error mod-500">Invalid post</div>';
    return;
}
?>
<div class="mod mod-post-teaser">
    <?php if ($article->teaser_html): ?>
        <div class="text-html">
            <?= $article->teaser_html; ?>
        </div>
    <?php endif; ?>

    <?php if ($article->teaser_link_caption): ?>
        <?= $this->Html->link($article->teaser_link_caption, $article->teaser_link_url); ?>
    <?php endif; ?>

</div>

