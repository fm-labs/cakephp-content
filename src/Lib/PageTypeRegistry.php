<?php

namespace Content\Lib;

use Cake\Core\App;
use Cake\Core\ObjectRegistry;
use Content\Page\PageTypeInterface;

class PageTypeRegistry extends ObjectRegistry
{

    /**
     * Should resolve the classname for a given object type.
     *
     * @param string $class The class to resolve.
     * @return string|false The resolved name or false for failure.
     */
    protected function _resolveClassName($class)
    {
        if (is_object($class)) {
            return $class;
        }

        return App::className($class, 'Page', 'PageType');
    }

    /**
     * Throw an exception when the requested object name is missing.
     *
     * @param string $class The class that is missing.
     * @param string $plugin The plugin $class is missing from.
     * @return void
     * @throws \Exception
     */
    protected function _throwMissingClassError($class, $plugin)
    {
        throw new \RuntimeException(sprintf('Could not load class %s', $class));
    }

    /**
     * Create an instance of a given classname.
     *
     * This method should construct and do any other initialization logic
     * required.
     *
     * @param string $class The class to build.
     * @param string $alias The alias of the object.
     * @param array $config The Configuration settings for construction
     * @return mixed
     */
    protected function _create($class, $alias, $config)
    {
        if (is_callable($class)) {
            $class = $class($alias);
        }

        if (is_object($class)) {
            $instance = $class;
        }

        if (!isset($instance)) {
            $instance = new $class($config);
        }

        if ($instance instanceof PageTypeInterface) {
            return $instance;
        }

        throw new \RuntimeException(
            'PageType must implement PageTypeInterface.'
        );
    }
}
