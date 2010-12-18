<?php

/**
 * Install file for settings
 *
 * @package     settings
 */

$_INSTALL['MAIN_MENU_ITEM'] = array (
    'title' => 'Settings',
    'url' => '/settings/index',
    'auth' => 'super',
    'module_name' => 'settings',
    'parent' => 0,
    'weight' => 3
);

$_INSTALL['VERSION'] = 1.037;

$_INSTALL['PUBLIC_CLONE_URL'] = 'git://github.com/diversen/settings.git';
