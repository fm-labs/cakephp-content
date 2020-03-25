<?php
declare(strict_types=1);

namespace Content\View;

use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Content\Model\Entity\Node;

class CategoryView extends ContentView
{
    /**
     * @param null $view
     * @param null $layout
     * @return null|string
     * @TODO Skip meta for inline categorys
     */
    public function render($view = null, $layout = null)
    {
        if ($this->get('category')) {
            $this->loadHelper('Media.Media');

            $category = $this->get('category');

            $metaTitle = $category->meta_title ?: $category->name;
            $categoryUrl = $this->Html->Url->build($category->url, true);

            // category title
            $this->assign('title', $metaTitle);

            // canonical url
            $this->Html->meta(['link' => $categoryUrl, 'rel' => 'canonical'], null, ['block' => true]);

            // meta tags
            $metaLang = $category->meta_lang ?: I18n::getLocale();
            $this->Html->meta(['name' => 'language', 'content' => $metaLang], null, ['block' => true]);

            $metaRobots = 'index,follow';
            $this->Html->meta(['name' => 'robots', 'content' => $metaRobots], null, ['block' => true]);

            $metaDescription = $category->meta_desc ?: $category->title;
            $this->Html->meta(['name' => 'description', 'content' => $metaDescription, 'lang' => $metaLang], null, ['block' => true]);

            $metaKeywords = $category->meta_keywords ?: $category->title;
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
            $this->Html->meta(['property' => 'og:url', 'content' => $categoryUrl], null, ['block' => true]);
            $this->Html->meta(['property' => 'og:type', 'content' => 'article'], null, ['block' => true]);

            $publishedTime = $category->publish_start ?: $category->created;
            if ($publishedTime) {
                $this->Html->meta(['property' => 'article:published_time', 'content' => $publishedTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            $expirationTime = $category->publish_end;
            if ($expirationTime) {
                $this->Html->meta(['property' => 'article:expiration_time', 'content' => $expirationTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            $modifiedTime = $category->modified;
            if ($modifiedTime) {
                $this->Html->meta(['property' => 'article:modified_time', 'content' => $modifiedTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            //@TODO Wrap in try/catch block
            if ($category->image) {
                $thumb = $this->Media->thumbnailUrl($category->image->filepath, ['width' => 200, 'height' => 200], true);
                $this->Html->meta(['property' => 'og:image', 'content' => $thumb], null, ['block' => true]);
                $this->Html->meta(['property' => 'twitter:image', 'content' => $thumb], null, ['block' => true]);
            }

            // Twitter Tags (https://dev.twitter.com/cards/markup)
            $this->Html->meta(['property' => 'twitter:card', 'content' => 'summary'], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:title', 'content' => $metaTitle], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:description', 'content' => Text::truncate($metaDescription, 190, ['ellipsis' => '...', 'exact' => false])], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:url', 'content' => $categoryUrl], null, ['block' => true]);

            // Breadcrumbs
            // If a menuitem-reference is set in request (?node_id=MENUITEMID), fetch the menuitem path and render as breadcrumbs.
            // This should be considered a workaround.
            // @TODO Use some category <-> menuitem mapping cache (performance)
            // @TODO Fallback to auto-detection, which nodes arle linked with this category, fetch path of first match
            // @TODO Skip breadcrumbs for inline categorys
            $nodeId = $this->request->getQuery('node_id');
            if ($nodeId) {
                $node = TableRegistry::getTableLocator()->get('Content.Nodes')->get($nodeId);
                $paths = TableRegistry::getTableLocator()->get('Content.Nodes')
                    ->find('path', ['for' => $nodeId])
                    ->where(['site_id' => $node->site_id])
                    ->all();
                $paths->each(function (Node $node) {
                    $this->Breadcrumbs->add($node->getLabel(), $node->getViewUrl());
                });
            } else {
                $this->Breadcrumbs->add($category->title, $categoryUrl);
            }
        }

        return parent::render($view, $layout);
    }
}
