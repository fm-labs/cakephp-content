<?php
declare(strict_types=1);

namespace Content\Controller\Admin;

use Settings\Form\SettingsForm;

/**
 * Class SettingsController
 *
 * @package Cupcake\Controller\Admin
 *
 */
class SettingsController extends AppController
{
    /**
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $form = new SettingsForm();
    }
}
