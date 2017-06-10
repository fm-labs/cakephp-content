<?php

namespace Content\View\Helper;

use Cake\View\Helper;

/**
 * Class BreadcrumbsHelper
 *
 * @package Content\View\Helper
 * @since CakePHP 3.3.6
 */
class BreadcrumbsHelper extends Helper\BreadcrumbsHelper
{

    /**
     * Default config for the helper.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'wrapper' => '<ol{{attrs}}>{{content}}</ol>',
            'item' => '<li itemscope itemtype="http://schema.org/breadcrumb"{{attrs}}><a href="{{url}}" itemprop="url"{{innerAttrs}}><span itemprop="title">{{title}}</span></a></li>{{separator}}',
            'itemWithoutLink' => '<li itemscope itemtype="http://schema.org/breadcrumb"{{attrs}}><span itemprop="title"{{innerAttrs}}>{{title}}</span></li>{{separator}}',
            'separator' => '<li{{attrs}}><span{{innerAttrs}}>{{separator}}</span></li>'
        ]
    ];

    public function add($title, $url = null, array $options = [])
    {
        //debug('Add Crumb ' . $title);
        parent::add($title, $url, $options);
    }

    /**
     * @param array $options
     * @param bool|false $startText
     * @return null|string
     * @deprecated
     */
    public function getCrumbList(array $options = [], $startText = false)
    {

        $this->templater()->add([
            'breadcrumb_list' => '<ol{{attrs}}>{{items}}</ol>',
            'breadcrumb_item' => '<li{{attrs}}>{{content}}</li>'
        ]);

        $defaults = ['separator' => '', 'escape' => true];
        $options += $defaults;

        $separator = $options['separator'];
        $escape = $options['escape'];
        unset($options['separator'], $options['escape']);

        $crumbs = $this->_prepareCrumbs($startText, $escape);
        if (empty($crumbs)) {
            return null;
        }

        $result = '';
        $listOptions = $options;
        foreach ($crumbs as $which => $crumb) {
            $options = [
                'itemscope' => true,
                'itemtype' => "http://schema.org/breadcrumb"
            ];
            if (empty($crumb[1])) {
                $elementContent = $crumb[0];
            } else {
                $linkAttrs = $crumb[2];
                $linkAttrs += ['itemprop' => 'url'];
                $elementContent = $this->link($crumb[0], $crumb[1], $linkAttrs);
            }

            $result .= $this->formatTemplate('breadcrumb_item', [
                'content' => $elementContent,
                'attrs' => $this->templater()->formatAttributes($options)
            ]);
        }

        return $this->formatTemplate('breadcrumb_list', [
            'items' => $result,
            'attrs' => $this->templater()->formatAttributes($listOptions)
        ]);
    }
}
