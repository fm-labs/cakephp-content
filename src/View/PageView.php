<?php
declare(strict_types=1);

namespace Content\View;

use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Cake\Utility\Text;

class PageView extends ContentView
{
    /**
     * {@inheritDoc}
     */
    public function render(?string $template = null, $layout = null): string
    {
        if ($this->get('page')) {
            $page = $this->get('page');

            /*
            if ($page instanceof MetaEntityInterface) {
                $pageUrl = $page->url;
                $metaTitle = $page->metaTitle; // getOption('metaTitle')
                $metaDescription = $page->getMetaDescription();
                $metaRobots = $page->getMetaRobots();
                $imgUrl = $page->getMetaImageUrl();
                $thumbUrl = $page->getMetaThumbImageUrl();
                $cannonicalUrl = $page->getMetaCannonicalUrl();
                $permaUrl = $page->getPermaUrl();
            }
            */

            $thumb = null;
            if (Plugin::isLoaded('Media')) {
                $this->loadHelper('Media.Media');
                if ($page->image && is_object($page->image)) {
                    $thumb = $this->Media->thumbnailUrl(
                        $page->image->filepath,
                        ['width' => 200, 'height' => 200],
                        true
                    );
                }
            }

            $pageUrl = $this->Html->Url->build($page->getUrl(), ['fullBase' => true]);
            $metaTitle = $page->meta_title ?: $page->title;
            $metaDescription = $page->meta_desc ?:
                Text::truncate(strip_tags($page->body_html), 150, ['exact' => false]);
            $metaDescription = $metaDescription ?:
                Text::truncate(strip_tags($page->body_html), 150, ['exact' => false]);

            // post title
            $this->assign('title', $metaTitle);

            // canonical url
            $this->Html->meta(['link' => $pageUrl, 'rel' => 'canonical'], null, ['block' => true]);

            // meta tags
            $metaLang = $page->meta_lang ?: I18n::getLocale();
            $this->Html->meta(['name' => 'language', 'content' => $metaLang], null, ['block' => true]);

            $metaRobots = 'index,follow';
            $this->Html->meta(['name' => 'robots', 'content' => $metaRobots], null, ['block' => true]);

            $this->Html->meta(
                ['name' => 'description', 'content' => $metaDescription, 'lang' => $metaLang],
                null,
                ['block' => true]
            );

            $metaKeywords = $page->meta_keywords ?: $page->title;
            $this->Html->meta(
                ['name' => 'keywords', 'content' => $metaKeywords, 'lang' => $metaLang],
                null,
                ['block' => true]
            );

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
            $this->Html->meta(['property' => 'og:url', 'content' => $pageUrl], null, ['block' => true]);
            $this->Html->meta(['property' => 'og:type', 'content' => 'page'], null, ['block' => true]);

            $publishedTime = $page->publish_start ?: $page->created;
            if ($publishedTime) {
                $this->Html->meta(
                    ['property' => 'page:published_time', 'content' => $publishedTime->format(DATE_ISO8601)],
                    null,
                    ['block' => true]
                );
            }

            $expirationTime = $page->publish_end;
            if ($expirationTime) {
                $this->Html->meta(
                    ['property' => 'page:expiration_time', 'content' => $expirationTime->format(DATE_ISO8601)],
                    null,
                    ['block' => true]
                );
            }

            $modifiedTime = $page->modified;
            if ($modifiedTime) {
                $this->Html->meta(
                    ['property' => 'page:modified_time', 'content' => $modifiedTime->format(DATE_ISO8601)],
                    null,
                    ['block' => true]
                );
            }

            if ($thumb !== null) {
                $this->Html->meta(['property' => 'og:image', 'content' => $thumb], null, ['block' => true]);
                $this->Html->meta(['property' => 'twitter:image', 'content' => $thumb], null, ['block' => true]);
            }

            // Twitter Tags (https://dev.twitter.com/cards/markup)
            $twtrDesc = Text::truncate($metaDescription, 190, ['ellipsis' => '...', 'exact' => false]);
            $this->Html->meta(['property' => 'twitter:card', 'content' => 'summary'], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:title', 'content' => $metaTitle], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:description', 'content' => $twtrDesc], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:url', 'content' => $pageUrl], null, ['block' => true]);

            // Breadcrumbs
            $this->Breadcrumbs->add($page->title, $pageUrl);
        }

        return parent::render($template, $layout);
    }
}
