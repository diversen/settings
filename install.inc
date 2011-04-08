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
    'weight' => 3,
    'admin_only' => true
);

$_INSTALL['VERSION'] = 1.31;

$_INSTALL['PUBLIC_CLONE_URL'] = 'git://github.com/diversen/settings.git';
$_INSTALL['PRIVATE_CLONE_URL'] = 'git@github.com:diversen/settings.git';

