<?php
declare(strict_types=1);

namespace Content;

use Cupcake\Lib\ClassRegistry;
use Cupcake\Lib\SingletonTrait;
use Cake\Collection\Collection;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Article;

/**
 * Class ContentManager
 *
 * @package Content\Lib
 */
class ContentManager
{
    use SingletonTrait {
        SingletonTrait::getInstance as getStaticInstance;
    }

    /**
     * @var string
     */
    public static $version;

    /**
     * @return \Content\ContentManager
     * @deprecated
     */
    public static function getInstance()
    {
        return self::getStaticInstance();
    }

    /**
     * @return string Content plugin version nummer
     * @deprecated
     */
    public static function version()
    {
        if (!isset(static::$version)) {
            static::$version = @file_get_contents(Plugin::path('Content') . DS . 'VERSION.txt');
        }

        return static::$version;
    }

    /**
     * @return \Cake\Datasource\ResultSetInterface
     * @deprecated
     */
    public static function getAvailablePageLayouts()
    {
        $PageLayouts = TableRegistry::getTableLocator()->get('Content.PageLayouts');

        return $PageLayouts->find('list')->all();
    }

    /**
     * @return \Cake\Datasource\EntityInterface|null
     * @deprecated
     */
    public static function getDefaultPageLayout()
    {
        $PageLayouts = TableRegistry::getTableLocator()->get('Content.PageLayouts');
        $pageLayout = $PageLayouts->find()->where(['is_default' => true])->first();

        return $pageLayout;
    }

    /**
     * @return array
     */
    public static function getAvailablePageTypes()
    {
        return ArticleManager::types();
    }

    /**
     * @param $article
     * @return object
     * @deprecated
     */
    public static function getArticleHandlerInstance(Article $article)
    {
        $articleType = $article->type;
        $instance = ClassRegistry::get('ArticleType', $articleType);
        $instance->setEntity($article);

        return $instance;
    }

    /**
     * @param $type
     * @return null
     * @deprecated
     */
    public static function getArticleModelByType($type)
    {
        $map = [
            'page' => 'Content.Articles',
            'post' => 'Content.Articles',
            'shop_category' => 'Shop.ShopCategories',
        ];

        if (isset($map[$type])) {
            return $map[$type];
        }

        return null;
    }

    public static function getMenuById($menuId)
    {
        /** @var \Content\Model\Table\MenusTable $Menus */
        $Menus = TableRegistry::getTableLocator()->get('Content.Menus');

        return $Menus->getMenu($menuId);
    }

    public static function getAvailableMenus()
    {
        /** @var \Content\Model\Table\MenusTable $Menus */
        $Menus = TableRegistry::getTableLocator()->get('Content.Menus');

        return $Menus->find('list', ['keyField' => 'id', 'valueField' => 'title'])
            ->where(['parent_id IS NULL'])
            ->all()
            ->toArray();
    }

    /**
     * @param $type
     * @param $typeid
     * @return \Cake\Datasource\EntityInterface|mixed|null
     * @deprecated
     */
    public static function getArticleByType($type, $typeid)
    {
        $modelClass = self::getArticleModelByType($type);
        if (!$modelClass) {
            return null;
        }

        return TableRegistry::getTableLocator()->get($modelClass)->get($typeid);
    }

    /**
     * @return array
     * @deprecated
     */
    public static function getModulesAvailable()
    {
        return ClassRegistry::show('ContentModule');
    }

    /**
     * @return array
     * @todo Refactor for module elements instead of module cells
     * @deprecated
     */
    public static function getModuleCellsAvailable()
    {
        $path = 'View' . DS . 'Module';
        $availableModules = [];

        $modulesLoader = function ($dir, $plugin = null) use (&$availableModules) {
            $folder = new Folder($dir);
            [$namespaces, ] = $folder->read();

            foreach ($namespaces as $ns) {
                $folder->cd($dir . DS . $ns);
                $widgets = $folder->findRecursive();
                array_walk($widgets, function ($val) use ($plugin, $dir, &$availableModules) {
                    $val = substr($val, strlen($dir . DS));
                    if (preg_match('/^(.*)Module\.php$/', $val, $matches)) {
                        $availableModules[] = $plugin ? $plugin . "." . $matches[1] : $matches[1];
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

    /**
     * @return array
     * @deprecated
     */
    public static function getModuleCellTemplatesAvailable()
    {
        $path = 'Template' . DS . 'Module';
        $availableModules = [];

        $modulesLoader = function ($dir, $plugin = null) use (&$availableModules) {
            $folder = new Folder($dir);
            [$namespaces, ] = $folder->read();

            foreach ($namespaces as $ns) {
                $folder->cd($dir . DS . $ns);
                $widgets = $folder->findRecursive();
                array_walk($widgets, function ($val) use ($plugin, $dir, &$availableModules) {
                    $val = substr($val, strlen($dir . DS));
                    if (preg_match('/^(.*)\.ctp$/', $val, $matches)) {
                        $availableModules[] = $plugin ? $plugin . "." . $matches[1] : $matches[1];
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

    /**
     * @return array
     */
    public static function getLayoutsAvailable()
    {
        $path = 'Template' . DS . 'Layout';
        $availableLayouts = [];

        $layoutLoader = function ($dir, $plugin = null) use (&$availableLayouts) {
            $folder = new Folder($dir);
            [, $layouts] = $folder->read();
            array_walk($layouts, function ($val) use ($plugin, $dir, &$availableLayouts) {
                //$val = substr($val, strlen($dir . DS));
                $val = basename($val, '.ctp');
                if (preg_match('/^frontend(\_(.*))?$/', $val, $matches)) {
                    $availableLayouts[] = $plugin ? $plugin . "." . $val : $val;
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

    /**
     * @return \Cake\Collection\Collection
     */
    public static function getThemesAvailable()
    {
        $availableThemes = [];

        /*
        $themesLoader = function ($dir, $plugin = null) use (&$availableThemes) {
            $folder = new Folder($dir);
            list($themes, ) = $folder->read();
            array_walk($themes, function ($val) use ($plugin, $dir, &$availableThemes) {
                //$val = substr($val, strlen($dir . DS));
                //$val = basename($val, '.ctp');
                if (preg_match('/^Theme(.*)$/', $val, $matches)) {
                    $availableThemes[] = ($plugin) ? $plugin . "." . $val : $val;
                }
            });
        };
        */
        $availableThemes = Plugin::loaded();

        // load app modules
        //$themesLoader(THEMES, null);
        // load modules from loaded plugins
        //foreach (Plugin::loaded() as $plugin) {
        //    $_path = Plugin::path($plugin) . 'src' . DS . $path;
        //    $themesLoader($_path, $plugin);
        //}

        $availableThemes = array_combine($availableThemes, $availableThemes);

        return new Collection($availableThemes);
    }

    /**
     * @return array
     * @deprecated
     */
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
        $filter = $filter ?: $defaultFilter;

        // finder
        $filesFinder = function ($dir, $plugin) use (&$available, $filter) {
            $folder = new Folder($dir);
            [, $files] = $folder->read();

            // apply filter
            if ($filter && is_callable($filter)) {
                $files = array_filter($files, $filter);
            }

            // extract cake template names
            array_walk($files, function (&$val, $key) use (&$available, $plugin) {
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

    /**
     * @return array
     * @deprecated
     */
    public static function getAvailableGalleryTemplates()
    {
        return self::getAvailableViewTemplates('Module/Flexslider');
    }

    /**
     * @return array
     * @deprecated
     */
    public static function getAvailablePageTemplates()
    {
        return self::getAvailableViewTemplates('Pages');
    }

    /**
     * @return array
     * @deprecated Use getAvailableArticleTemplates() instead
     */
    public static function getAvailableArticleTeaserTemplates()
    {
        return self::getAvailableArticleTemplates();

        $path = 'Template' . DS . 'Articles';
        $available = [];

        $modulesLoader = function ($dir, $plugin = null) {
            $list = [];
            $folder = new Folder($dir);
            [, $files] = $folder->read();

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

    /**
     * @return array
     * @deprecated
     */
    public static function getAvailableArticleTemplates()
    {
        $path = 'Template' . DS . 'Articles';
        $available = [];

        $modulesLoader = function ($dir, $plugin = null) {
            $list = [];
            $folder = new Folder($dir);
            [, $files] = $folder->read();

            array_walk($files, function ($val) use ($plugin, $dir, &$list) {
                if (preg_match('/^\_/', $val)) {
                    return;
                } elseif (preg_match('/^([\w\_]+)\.ctp$/', $val, $matches)) {
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
