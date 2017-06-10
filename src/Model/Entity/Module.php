<?php
namespace Content\Model\Entity;

use Banana\Lib\ClassRegistry;
use Cake\ORM\Entity;

/**
 * Module Entity.
 *
 * @TODO Refactor with type handler interface
 */
class Module extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'name' => true,
        'title' => true,
        'path' => true,
        'params' => true,
        'params_arr' => true,
        'template' => true, //@TODO add field in database
    ];

    /**
     * @var array
     */
    protected $_virtual = [
        'cellClass'
    ];

    /**
     * @param array $properties
     * @param array $options
     */
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);
        $this->expand();
    }

    /**
     * Decode JSON params into params_arr property
     */
    public function expand()
    {
        if (isset($this->_properties['params'])) {
            $this->setParams((array)json_decode($this->_properties['params'], true));
            $this->set($this->_properties['params_arr']);
        }
    }

    /**
     * @param array $params
     * @param bool|true $merge
     */
    public function setParams($params = [], $merge = true)
    {

        if ($merge) {
            $this->_properties['params_arr'] = array_merge($this->params_arr, $params);
        } else {
            $this->_properties['params_arr'] = $params;
        }

        $this->_properties['params'] = json_encode($this->_properties['params_arr']);
        $this->dirty('params', true);
    }

    /**
     * @param array $defaults
     */
    public function setDefaults(array $defaults)
    {
        $params = array_merge($defaults, $this->params_arr);
        $this->setParams($params, false);
    }

    /**
     * @return array
     */
    public function getAdminPreviewUrl()
    {
        $paramsArr = $this->_getParamsArr();

        $url = [
            'plugin' => 'Content',
            'prefix' => 'admin',
            'controller' => 'Modules',
            'action' => 'preview',
            'path' => $this->path,
            'params' => base64_encode(json_encode($paramsArr))
        ];

        return $url;
    }

    /**
     * @return null|string
     */
    protected function _getCellClass()
    {
        $path = $this->get('path');

        /*
        $class = ClassRegistry::getClass('ContentModule', $path);
        if (!$class) {
            return false;
        }

        list($ns,$className) = namespaceSplit($class);
        $className = substr($className, 0, -4);
        $ns = explode('\\', $ns);
        if ($ns && $ns[0] && $ns[0] != "App" && $ns[0] != "Cake") {
            $className = $ns[0] . '.' . $className;
        }
        */
        return ClassRegistry::getClass('ContentModule', $path);
    }

    /**
     * @param null $params
     */
    protected function _setParams($params = null)
    {
        $this->setParams((array)json_decode($params, true));
        $this->set($this->_properties['params_arr']);
    }

    /**
     * @return null
     */
    protected function _getParams()
    {
        if (!isset($this->_properties['params']) && isset($this->_properties['params_arr'])) {
            $this->_properties['params'] = json_encode($this->_properties['params_arr']);
        }

        return (isset($this->_properties['params'])) ? $this->_properties['params'] : null;
    }

    /**
     * @return mixed
     */
    protected function _getParamsArr()
    {
        $this->_properties['params_arr'] = (isset($this->_properties['params_arr']))
            ? $this->_properties['params_arr']
            : [];

        return $this->_properties['params_arr'];
    }

    /**
     * @param array|string $property
     * @param null $value
     * @param array $options
     * @return $this|void
     */
    public function set($property, $value = null, array $options = [])
    {
        parent::set($property, $value, $options);

        $dirtyParam = false;
        foreach (array_keys((array)$this->params_arr) as $param) {
            if (!$this->has($param)) {
                $this->_properties[$param] = $this->_properties['params_arr'][$param];
            } elseif ($this->dirty($param)) {
                $dirtyParam = true;
                $this->_properties['params_arr'][$param] = $this->get($param);
            }
        }

        if ($dirtyParam) {
            $this->_properties['params'] = json_encode($this->params_arr);
            $this->dirty('params', true);
        }
    }
}
