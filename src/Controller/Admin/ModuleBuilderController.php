<?php
namespace Content\Controller\Admin;

use Cake\Utility\Hash;
use Content\Form\ModuleParamsForm;
use Content\Lib\ContentManager;
use Content\View\ViewModule;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Core\Plugin;
use Content\Model\Table\ModulesTable;
use Cake\Filesystem\Folder;
use Content\Model\Entity\Module;
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
            $className = App::className($class, 'View/Cell', 'ModuleCell');

            $module = $this->Modules->newEntity($query, ['validate' => false]);
            $module->path = $class;
            if (!$module->name) {
                list($plugin, $moduleClass) = pluginSplit($class);
                $module->name = __('Mod {0} {1}', $moduleClass, date("Y-m-d"));
            }
        } else {
            $module = $this->Modules->get($id);
            $className = App::className($module->path, 'View/Cell', 'ModuleCell');
        }


        if (!$module) {
            throw new NotFoundException('Module not found');
        }

        if (!$className) {
            $this->Flash->error('Module class path not set or not set');
            return $this->redirect(['action' => 'index']);
        }

        $formInputs = $className::inputs();
        $formDefaults = $className::defaults();
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

        $paths = Hash::extract(ContentManager::getModulesAvailable(), '{s}.class');
        $this->set('paths', array_combine($paths, $paths));
        $this->set('module', $module);
        $this->set('formInputs', $formInputs);
        $this->set('data', $this->request->data());
    }

    public function edit($id = null)
    {
        $this->setAction('build', $id);
    }
}
