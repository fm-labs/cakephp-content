<?php
declare(strict_types=1);

namespace Content;

use Cake\Utility\Inflector;

class ArticleManager
{
    protected static $types = [];

    /**
     * Return list of registered types
     */
    public static function types()
    {
        return self::$types;
    }

    /**
     * Register an aliased class with it's configuration
     *
     * @param string|array $alias
     * @param array $config
     */
    public static function registerType($alias, array $config = [])
    {
        if (is_array($alias)) {
            array_walk($alias, function ($_config, $_alias) {
                self::registerType($_alias, $_config);
            });

            return;
        }

        if (isset(self::$types[$alias])) {
            throw new \RuntimeException(sprintf("Can not register type '%s' in ArticleManager: Already registered", $alias));
        }

        if (!isset($config['className'])) {
            throw new \RuntimeException(sprintf("Can not register type '%s' in ArticleManager: No class name defined", $alias));
        }

        if (!isset($config['label'])) {
            $config['label'] = Inflector::humanize($alias);
        }

        self::$types[$alias] = $config;
    }

    /**
     * @return array|null
     */
    public static function getType($alias)
    {
        return self::$types[$alias] ?? null;
    }
}
