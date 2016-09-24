<?php
use Backend\Lib\Backend;
use Content\Lib\ContentManager;
use Cake\Core\Configure;
use Cake\Core\Plugin;

if (!Configure::read('Content')) {
    die("Content Plugin not configured");
}

/**
 * Core Content plugins (required)
 */
Plugin::load('Backend', ['bootstrap' => true, 'routes' => true]);
Plugin::load('User', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Tree', ['bootstrap' => true, 'routes' => false]);
Plugin::load('Media', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Settings', ['bootstrap' => true, 'routes' => true]);

/**
 * Theme plugins
 */
if (Configure::check('Content.Frontend.theme')) {
    try {
        Plugin::load(Configure::read('Content.Frontend.theme'), ['bootstrap' => true, 'routes' => true]);
    } catch (\Cake\Core\Exception\Exception $ex) {
        die ($ex->getMessage());
    }
}

/**
 * Backend hook
 */
Backend::hookPlugin('Content');