<?php
declare(strict_types=1);

namespace Content\Routing\Route;

use Cake\I18n\I18n;
use Cake\Routing\Route\Route;

class I18nRoute extends Route
{
    public function parseRequest($url)
    {
        $params = parent::parseRequest($url);
        //if (!$params) {
        //    return false;
        //}

        //if (!isset($params['locale'])) {
        //    $params['locale'] = I18n::getLocale();
        //}

        //debug($params);
        return $params;
    }

    public function match(array $url, array $context = [])
    {
        //debug($url);
        if (!isset($url['locale'])) {
            $url['locale'] = I18n::getLocale();
        }
        $result = parent::match($url, $context);
        //debug($result);
        return $result;
    }
}
