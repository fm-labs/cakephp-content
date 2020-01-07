<?php

namespace Content\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\View\Helper;

/**
 * Class ContentHelper
 *
 * @package Content\View\Helper
 */
class ContentHelper extends Helper
{
    /**
     * @var array
     */
    protected $_urlPlaceholderCache = [];

    /**
     * Replace url placeholders with format `{{Plugin.Model:id}}`
     *
     * @param $text
     * @return string
     */
    public function parseUrlPlaceholders($text)
    {
        $text = preg_replace_callback('/\{\{(.*)\}\}/U', function ($matches) {

            $placeholder = $matches[1];

            if (isset($this->_urlPlaceholderCache[$placeholder])) {
                return $this->_urlPlaceholderCache[$placeholder];
            }

            $args = explode(':', $placeholder);
            $modelName = array_shift($args);

            if (count($args) < 1) {
                $id = null;
            } else {
                $id = array_shift($args);
            }

            try {
                list($plugin, $model) = pluginSplit($modelName);
                $url = ['plugin' => $plugin, 'controller' => $model, 'action' => 'view', $id];
                $url = Router::url($url);
            } catch (\Exception $ex) {
                $url = '/';
                debug($ex->getMessage());
            }

            return $this->_urlPlaceholderCache[$placeholder] = $url;
        }, $text);

        return $text;
    }

    /**
     * @param $text
     * @return string
     */
    public function userHtml($text)
    {
        $text = $this->parseUrlPlaceholders($text);

        return $text;
    }
}
