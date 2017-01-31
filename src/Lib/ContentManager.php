<?php
namespace Content\Lib;

use Banana\Lib\ClassRegistry;
use Cake\Core\App;
use Cake\Datasource\EntityInterface;
use Cake\Utility\Hash;
use Content\Model\Entity\Node;
use Content\Model\Entity\Page;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Content\Model\Entity\Post;
use Content\Post\PostHandlerInterface;

class ContentManager
{

    public static $version;

    /**
     * @return string Content plugin version nummer
     */
    public static function version()
    {
        if (!isset(static::$version)) {
            static::$version = @file_get_contents(Plugin::path('Content') . DS . 'VERSION.txt');
        }
        return static::$version;
    }


    public static function getAvailablePageLayouts()
    {
        $PageLayouts = TableRegistry::get('Content.PageLayouts');
        return $PageLayouts->find('list')->all();
    }


    public static function getDefaultPageLayout()
    {
        $PageLayouts = TableRegistry::get('Content.PageLayouts');
        $pageLayout = $PageLayouts->find()->where(['is_default' => true])->first();
        return $pageLayout;
    }

    /**
     * @param Page $page
     * @deprecated
     */
    public static function getPageHandler(Page $page)
    {
        $pageType = $page->getPageType();
        return ClassRegistry::createInstance('PageType', $pageType, $page);
    }

    public static function getMenuHandlerInstance(Node $node)
    {
        $menuType = $node->type;
        $instance = ClassRegistry::get('NodeType', $menuType);
        $instance->setNode($node);
        return $instance;
    }

    /**
     * @param $post
     * @return PostHandlerInterface
     */
    public static function getPostHandlerInstance(Post $post)
    {
        $postType = $post->type;
        $instance = ClassRegistry::get('PostType', $postType);
        $instance->setEntity($post);
        return $instance;
    }

    public static function getPostModelByType($type)
    {
        $map = [
            'page' => 'Content.Posts',
            'post' => 'Content.Posts',
            'shop_category' => 'Shop.ShopCategories',
        ];

        if (isset($map[$type])) {
            return $map[$type];
        }
        return null;
    }

    public static function getPostByType($type, $typeid)
    {
        $modelClass = self::getPostModelByType($type);
        if (!$modelClass) {
            return null;
        }

        return TableRegistry::get($modelClass)->get($typeid);
    }

    public static function getModulesAvailable()
    {
        return ClassRegistry::show('ContentModule');
    }


    /**
     * @return array
     * @todo Refactor for module elements instead of module cells
     */
    public static function getModuleCellsAvailable()
    {
        $path = 'View' . DS . 'Module';
        $availableModules = [];

        $modulesLoader = function ($dir, $plugin = null) use (&$availableModules) {
            $folder = new Folder($dir);
            list($namespaces,) = $folder->read();

            foreach ($namespaces as $ns) {
                $folder->cd($dir . DS . $ns);
                $widgets = $folder->findRecursive();
                array_walk($widgets, function ($val) use ($plugin, $dir, &$availableModules) {
                    $val = substr($val, strlen($dir . DS));
                    if (preg_match('/^(.*)Module\.php$/', $val, $matches)) {
                        $availableModules[] = ($plugin) ? $plugin . "." . $matches[1] : $matches[1];
                    }
                });
            }
        };

        // load app modules
        $modulesLoader(APP . $path, null);
        // load modules from loaded plugins
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $modulesLoader($_path, $plugin);
        }

        return $availableModules;
    }

    public static function getModuleCellTemplatesAvailable()
    {
        $path = 'Template' . DS . 'Module';
        $availableModules = [];

        $modulesLoader = function ($dir, $plugin = null) use (&$availableModules) {
            $folder = new Folder($dir);
            list($namespaces,) = $folder->read();

            foreach ($namespaces as $ns) {
                $folder->cd($dir . DS . $ns);
                $widgets = $folder->findRecursive();
                array_walk($widgets, function ($val) use ($plugin, $dir, &$availableModules) {
                    $val = substr($val, strlen($dir . DS));
                    if (preg_match('/^(.*)\.ctp$/', $val, $matches)) {
                        $availableModules[] = ($plugin) ? $plugin . "." . $matches[1] : $matches[1];
                    }
                });
            }
        };

        // load app modules
        $modulesLoader(APP . $path, null);
        // load modules from loaded plugins
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $modulesLoader($_path, $plugin);
        }

        return array_combine($availableModules, $availableModules);
    }

    public static function getLayoutsAvailable()
    {
        $path = 'Template' . DS . 'Layout';
        $availableLayouts = [];

        $layoutLoader = function ($dir, $plugin = null) use (&$availableLayouts) {
            $folder = new Folder($dir);
            list(,$layouts) = $folder->read();
            array_walk($layouts, function ($val) use ($plugin, $dir, &$availableLayouts) {
                //$val = substr($val, strlen($dir . DS));
                $val = basename($val, '.ctp');
                if (preg_match('/^frontend(\_(.*))?$/', $val, $matches)) {

                    $availableLayouts[] = ($plugin) ? $plugin . "." . $val : $val;
                }
            });
        };

        // load app modules
        $layoutLoader(APP . $path, null);
        // load modules from loaded plugins
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $layoutLoader($_path, $plugin);
        }

        $availableLayouts = array_combine($availableLayouts, $availableLayouts);
        return $availableLayouts;
    }

    public static function getThemesAvailable()
    {
        $availableThemes = [];

        $themesLoader = function ($dir, $plugin = null) use (&$availableThemes) {
            $folder = new Folder($dir);
            list($themes,) = $folder->read();
            array_walk($themes, function ($val) use ($plugin, $dir, &$availableThemes) {
                //$val = substr($val, strlen($dir . DS));
                //$val = basename($val, '.ctp');
                if (preg_match('/^Theme(.*)$/', $val, $matches)) {
                    $availableThemes[] = ($plugin) ? $plugin . "." . $val : $val;
                }
            });
        };

        // load app modules
        $themesLoader(THEMES, null);
        // load modules from loaded plugins
        //foreach (Plugin::loaded() as $plugin) {
        //    $_path = Plugin::path($plugin) . 'src' . DS . $path;
        //    $themesLoader($_path, $plugin);
        //}

        $availableThemes = array_combine($availableThemes, $availableThemes);
        return $availableThemes;
    }

    public static function getContentSections()
    {
        return [
            'before' => 'before',
            'after' => 'after',
            'main' => 'main',
            'top' => 'top',
            'bottom' => 'bottom',
        ];
    }

    /**
     * @deprecated Use getContentSections() instead
     */
    public static function listContentSections()
    {
        return self::getContentSections();
    }


    /**
     * Find content view templates in app, plugins and themes templates
     * @param $path
     * @param null $filter
     * @return array
     */
    public static function getAvailableViewTemplates($path, $filter = null)
    {
        $path = 'Template/' . $path;
        $available = [];

        // filter
        $defaultFilter = function ($val) {
            if (preg_match('/^\_/', $val)) {
                return false;
            }
            return true;
        };
        $filter = ($filter) ?: $defaultFilter;

        // finder
        $filesFinder = function ($dir, $plugin) use (&$available, $filter) {
            $folder = new Folder($dir);
            list(,$files) = $folder->read();

            // apply filter
            if ($filter && is_callable($filter)) {
                $files = array_filter($files, $filter);
            }

            // extract cake template names
            array_walk($files, function(&$val, $key) use (&$available, $plugin) {
                if (preg_match('/^([\w\_]+)\.ctp$/', $val, $matches)) {
                    $name = $matches[1];
                    //$template = ($plugin) ? $plugin . '.' . $name : $name;
                    $available[$name] = $name;
                }
            });
        };

        $filesFinder(APP . $path, null);
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $filesFinder($_path, $plugin);
        }

        /*
        // find app templates
        $available['App'] = $filesFinder(APP . $path, null);

        // find templates from loaded plugins
        debug(Plugin::loaded());
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $available[$plugin] = $filesFinder($_path, $plugin);
        }

        debug($available);
        */

        //sort($available);

        asort($available);
        return $available;
    }



    public static function getAvailableGalleryTemplates()
    {
        return self::getAvailableViewTemplates('Galleries');
    }

    public static function getAvailablePageTemplates()
    {
        return self::getAvailableViewTemplates('Pages');
    }

    public static function getAvailablePageTypes()
    {
        $names = Hash::extract(self::$registry['PageType'], '{s}.name');
        return array_combine(array_keys(self::$registry['PageType']), $names);
    }

    /**
     * @return array
     * @deprecated Use getAvailablePostTemplates() instead
     */
    public static function getAvailablePostTeaserTemplates()
    {
        return self::getAvailablePostTemplates();

        $path = 'Template' . DS . 'Posts';
        $available = [];

        $modulesLoader = function ($dir, $plugin = null) {
            $list = [];
            $folder = new Folder($dir);
            list(,$files) = $folder->read();

            array_walk($files, function ($val) use ($plugin, $dir, &$list) {
                if (preg_match('/^teaser_([\w\_]+)\.ctp$/', $val, $matches)) {
                    $name = $matches[1];
                    //$template = ($plugin) ? $plugin . "." . 'teaser_' . $matches[1] : 'teaser_' . $matches[1];
                    $template = 'teaser_' . $matches[1];
                    $list[$template] = $name;
                }
            });

            return $list;
        };

        // load app modules
        $available['App'] = $modulesLoader(APP . $path, null);

        // load modules from loaded plugins
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $templates = $modulesLoader($_path, $plugin);
            if ($templates) {
                $available[$plugin] = $templates;
            }
        }

        return $available;
    }

    public static function getAvailablePostTemplates()
    {
        $path = 'Template' . DS . 'Posts';
        $available = [];

        $modulesLoader = function ($dir, $plugin = null) {
            $list = [];
            $folder = new Folder($dir);
            list(,$files) = $folder->read();

            array_walk($files, function ($val) use ($plugin, $dir, &$list) {
                if (preg_match('/^\_/', $val)) {
                    return;
                }
                elseif (preg_match('/^([\w\_]+)\.ctp$/', $val, $matches)) {
                    $name = $matches[1];
                    //$template = ($plugin) ? $plugin . "." . 'teaser_' . $matches[1] : 'teaser_' . $matches[1];
                    $template = $matches[1];
                    $list[$template] = $name;
                }
            });

            return $list;
        };

        // load app modules
        $available['App'] = $modulesLoader(APP . $path, null);

        // load modules from loaded plugins
        foreach (Plugin::loaded() as $plugin) {
            $_path = Plugin::path($plugin) . 'src' . DS . $path;
            $templates = $modulesLoader($_path, $plugin);
            if ($templates) {
                $available[$plugin] = $templates;
            }
        }

        return $available;
    }


}