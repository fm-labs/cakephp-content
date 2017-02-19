<?php
namespace Content\Controller\Admin;

use Banana\Exception\ClassNotFoundException;
use Banana\Lib\ClassRegistry;
use Cake\Core\App;
use Cake\Utility\Hash;
use Content\Lib\ContentManager;
use Content\View\Cell\ModuleCell;
use Cake\Core\Configure;
use Content\Model\Table\ModulesTable;
use Cake\Network\Exception\NotFoundException;

/**
 * Class ModuleBuilderController
 * @package App\Controller\Admin
 *
 * @property ModulesTable $Modules
 */
class ModuleBuilderController extends AppController
{
    public $modelClass = "Content.Modules";

    public function index()
    {
        $this->set('availableModules', ContentManager::getModulesAvailable());
    }

    public function preview()
    {
        $path = $this->request->query('path');
        $paramsBase64 = $this->request->query('params');

        if (!$path) {
            throw new \InvalidArgumentException("Module path not set");
        }

        if (!$paramsBase64) {
            throw new \InvalidArgumentException("Module params not set");
        }

        $params = base64_decode($paramsBase64);
        $params = json_decode($params, true);

        $this->layout = "iframe/module";

        $this->set('modulePath', $path);
        $this->set('moduleParams', $params);
    }

    public function build($id = null)
    {
        $class = $this->request->query('path');
        $query = $this->request->query;

        if (!$id) {
            $module = $this->Modules->newEntity($query, ['validate' => false]);
            $module->path = $class;
            if (!$module->name) {
                list($plugin, $moduleClass) = pluginSplit($class);
                $module->name = __('Mod {0} {1}', $moduleClass, date("Y-m-d"));
            }
        } else {
            $module = $this->Modules->get($id);
            $class = $module->path;
        }


        if (!$module) {
            throw new NotFoundException('Module not found');
        }

        if (!$class) {
            $this->Flash->error('Module class path not set or not set');
            return $this->redirect(['action' => 'index']);
        }

        try {
            // resolve class by alias
            $class = ClassRegistry::getClass('ContentModule', $class);

            // resolve class path from dot notation
            $className = App::className($class, 'View/Cell', 'Cell');
            if (!$className) {
                throw new ClassNotFoundException(['class' => $class]);
            }

            $instance = new $className();
            if (!($instance instanceof ModuleCell)) {
               throw new \InvalidArgumentException('Module instance MUST be an instance of ModuleCell');
            }

        } catch (ClassNotFoundException $ex) {

            $this->Flash->error('Error while loading module instance: ' . $ex->getMessage());
            return $this->redirect(['action' => 'build']);
        }


        $formInputs = $instance::inputs();
        $formDefaults = $instance::defaults();
        $module->accessible(array_keys($formDefaults), true);
        $module->accessible('_save', true);
        $module->setDefaults($formDefaults);

        if ($this->request->is('post') || $this->request->is('put')) {
            $module = $this->Modules->patchEntity($module, $this->request->data());

            if ($module->_save == true && $module = $this->Modules->save($module)) {
                $this->Flash->success(__d('content','Module has been saved with ID {0}', $module->id));

                } elseif ($module->_save == true) {
                    debug($module->errors());
                }

            $previewUrl = $module->getAdminPreviewUrl();
            $this->set('previewUrl', $previewUrl);
        }

        $this->set('paths', ContentManager::getModulesAvailable());
        $this->set('module', $module);
        $this->set('formInputs', $formInputs);
        $this->set('data', $this->request->data());
    }

    public function edit($id = null)
    {
        $this->setAction('build', $id);
    }
}
