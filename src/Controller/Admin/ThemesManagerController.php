<?php
namespace Content\Controller\Admin;

use Cake\Core\App;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;

/**
 * Class ThemesManagerController
 * @package App\Controller\Admin
 *
 */
class ThemesManagerController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        // get list of available themes in THEMES directory
        $dir = new Folder(THEMES);
        list($themeNames,) = $dir->read();

        debug($themeNames);

        $themes = [];
        foreach ($themeNames as $theme) {
            $themes[] = [
                'name' => $theme,
                'loaded' => Plugin::loaded($theme),
            ];
        }
        $this->set('themesAvailable', $themes);

        // get installed themes from db
        //$this->loadModel("Themes");

        //$themes = $this->Themes->find()->all();
        //$this->set('themesInstalled', $themes);
    }

    /**
     * @param $themeName
     */
    public function details($themeName)
    {
        $themePath = THEMES . $themeName . DS;
        $folder = new Folder($themePath);

        $folder->cd($themePath . "src/Template/Layout");
        list(,$layoutTemplates) = $folder->read();

        $themeDetails = [
            'name' => $themeName,
            'path' => $themePath,
            'layout_templates' => $layoutTemplates,
        ];

        $this->set('themeDetails', $themeDetails);
    }
}
