<?php
declare(strict_types=1);

namespace Content\View;

use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Cake\Utility\Text;

class ArticleView extends ContentView
{
    /**
     * @param null $template
     * @param null $layout
     * @return null|string
     * @TODO Skip meta for inline posts
     */
    public function render(?string $template = null, $layout = null): string
    {
        if ($this->get('article')) {
            $article = $this->get('article');
            $thumb = null;

            if (Plugin::isLoaded('Media')) {
                $this->loadHelper('Media.Media');
                if ($article->image && is_object($article->image)) {
                    $thumb = $this->Media->thumbnailUrl($article->image->filepath, ['width' => 200, 'height' => 200], true);
                }
            }

            $metaTitle = $article->meta_title ?: $article->title;
            $metaDescription = $article->meta_desc ?: Text::truncate(strip_tags($article->teaser_html), 150, ['exact' => false]);
            $metaDescription = $metaDescription ?: Text::truncate(strip_tags($article->body_html), 150, ['exact' => false]);
            $articleUrl = $this->Html->Url->build($article->getUrl(), true);

            // post title
            $this->assign('title', $metaTitle);

            // canonical url
            $this->Html->meta(['link' => $articleUrl, 'rel' => 'canonical'], null, ['block' => true]);

            // meta tags
            $metaLang = $article->meta_lang ?: I18n::getLocale();
            $this->Html->meta(['name' => 'language', 'content' => $metaLang], null, ['block' => true]);

            $metaRobots = 'index,follow';
            $this->Html->meta(['name' => 'robots', 'content' => $metaRobots], null, ['block' => true]);

            $this->Html->meta(['name' => 'description', 'content' => $metaDescription, 'lang' => $metaLang], null, ['block' => true]);

            $metaKeywords = $article->meta_keywords ?: $article->title;
            $this->Html->meta(['name' => 'keywords', 'content' => $metaKeywords, 'lang' => $metaLang], null, ['block' => true]);

            //$this->Html->meta(['name' => 'revisit-after', 'content' => '7 days'], null, ['block' => true]);
            //$this->Html->meta(['name' => 'expires', 'content' => 0], null, ['block' => true]);
            //$this->Html->meta(['name' => 'abstract', 'content' => $metaDescription], null, ['block' => true]);
            //$this->Html->meta(['name' => 'distribution', 'content' => 'global'], null, ['block' => true]);
            //$this->Html->meta(['name' => 'generator', 'content' => 'Content Cake x.x.x'], null, ['block' => true]);
            //$this->Html->meta(['name' => 'googlebot', 'content' => ''], null, ['block' => true]);
            //$this->Html->meta(['name' => 'no-email-collection', 'content' => 'http://www.metatags.nl/nospamharvesting'], null, ['block' => true]);
            //$this->Html->meta(['name' => 'rating', 'content' => 'general'], null, ['block' => true]);
            //$this->Html->meta(['name' => 'reply-to', 'content' => 'webmaster@exmaple.org'], null, ['block' => true]);

            //$this->Html->meta(['http-equiv' => 'cache-control', 'content' => 'public'], null, ['block' => true]);
            //$this->Html->meta(['http-equiv' => 'content-type', 'content' => 'text/html'], null, ['block' => true]);
            //$this->Html->meta(['http-equiv' => 'content-language', 'content' => $metaLang], null, ['block' => true]);
            //$this->Html->meta(['http-equiv' => 'pragma', 'content' => 'no-cache'], null, ['block' => true]);


            // Open Graph Tags
            $this->Html->meta(['property' => 'og:title', 'content' => $metaTitle], null, ['block' => true]);
            $this->Html->meta(['property' => 'og:description', 'content' => $metaDescription], null, ['block' => true]);
            $this->Html->meta(['property' => 'og:url', 'content' => $articleUrl], null, ['block' => true]);
            $this->Html->meta(['property' => 'og:type', 'content' => 'article'], null, ['block' => true]);

            $publishedTime = $article->publish_start ?: $article->created;
            if ($publishedTime) {
                $this->Html->meta(['property' => 'article:published_time', 'content' => $publishedTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            $expirationTime = $article->publish_end;
            if ($expirationTime) {
                $this->Html->meta(['property' => 'article:expiration_time', 'content' => $expirationTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            $modifiedTime = $article->modified;
            if ($modifiedTime) {
                $this->Html->meta(['property' => 'article:modified_time', 'content' => $modifiedTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            if ($thumb !== null) {
                $this->Html->meta(['property' => 'og:image', 'content' => $thumb], null, ['block' => true]);
                $this->Html->meta(['property' => 'twitter:image', 'content' => $thumb], null, ['block' => true]);
            }

            // Twitter Tags (https://dev.twitter.com/cards/markup)
            $this->Html->meta(['property' => 'twitter:card', 'content' => 'summary'], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:title', 'content' => $metaTitle], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:description', 'content' => Text::truncate($metaDescription, 190, ['ellipsis' => '...', 'exact' => false])], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:url', 'content' => $articleUrl], null, ['block' => true]);

            // Breadcrumbs
            $this->Breadcrumbs->add($article->title, $articleUrl);
        }

        return parent::render($view, $layout);
    }
}
