<?php

namespace Content\View;

use Cake\I18n\I18n;
use Cake\Routing\Router;

class PageView extends ContentView
{

    public function render($view = null, $layout = null)
    {
        $this->helpers()->load('Time');

        if ($this->get('page')) {
            $page = $this->get('page');

            $metaTitle = ($page->meta_title) ?: $page->getPageTitle();
            $pageUrl = $this->Html->Url->build($page->url, true);

            // page title
            $this->assign('title', $metaTitle);

            // canonical url
            $this->Html->meta(['link' => $pageUrl, 'rel' => 'canonical'], null, ['block' => true]);

            // meta tags
            $metaLang = ($page->meta_lang) ?: I18n::locale();
            $this->Html->meta(['name' => 'language', 'content' => $metaLang], null, ['block' => true]);

            $metaRobots = 'index,follow';
            $this->Html->meta(['name' => 'robots', 'content' => $metaRobots], null, ['block' => true]);

            $metaDescription = ($page->meta_desc) ?: $page->title;
            $this->Html->meta(['name' => 'description', 'content' => $metaDescription, 'lang' => $metaLang], null, ['block' => true]);

            $metaKeywords = ($page->meta_keywords) ?: $page->title;
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
            $this->Html->meta(['property' => 'og:url', 'content' => $pageUrl], null, ['block' => true]);
            $this->Html->meta(['property' => 'og:type', 'content' => 'article'], null, ['block' => true]);

            $publishedTime = ($page->publish_start) ?: $page->created;
            if ($publishedTime) {
                $this->Html->meta(['property' => 'article:published_time', 'content' => $publishedTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            $expirationTime = ($page->publish_end);
            if ($expirationTime) {
                $this->Html->meta(['property' => 'article:expiration_time', 'content' => $expirationTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            $modifiedTime = $page->modified;
            if ($modifiedTime) {
                $this->Html->meta(['property' => 'article:modified_time', 'content' => $modifiedTime->format(DATE_ISO8601)], null, ['block' => true]);
            }

            //if ($page->getPageImage()) {
            //    $this->Html->meta(['property' => 'og:image', 'content' => $this->Media->thumbnailUrl($page->getPageImage()->path)], null, ['block' => true]);
            //}


            // Twitter Tags
            $this->Html->meta(['property' => 'twitter:card', 'content' => 'summary'], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:title', 'content' => $metaTitle], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:description', 'content' => $metaDescription], null, ['block' => true]);
            $this->Html->meta(['property' => 'twitter:url', 'content' => $pageUrl], null, ['block' => true]);

            foreach ($page->getPath() as $node) {
                if (!$node->parent_id || $node->hide_in_nav) continue;
                $this->Breadcrumbs->add($node->getPageTitle(), $node->getPageUrl());
            }

            //$this->Breadcrumbs->add($page->getPageTitle(), $page->getPageUrl());

        }

        return parent::render($view, $layout);
    }
}
