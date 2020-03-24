<?php

namespace Content;

use Cake\Utility\Inflector;

class MenuManager
{
    protected static $types = [];

    public static function registerType($alias, array $config = [])
    {
        if (is_array($alias)) {
            array_walk($alias, function($_config, $_alias) {
                self::registerType($_alias, $_config);
            });

            return;
        }

        if (isset(self::$types[$alias])) {
            throw new \RuntimeException(sprintf("Can not register type '%s' in MenuManager: Already registered", $alias));
        }

        if (!isset($config['className'])) {
            throw new \RuntimeException(sprintf("Can not register type '%s' in MenuManager: No class name defined", $alias));
        }

        if (!isset($config['title'])) {
            $config['title'] = Inflector::humanize($alias);
        }

        self::$types[$alias] = $config;
    }

    public static function types()
    {
        return self::$types;
    }
}