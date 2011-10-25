<?php

/**
 * Install file for settings
 *
 * @package     settings
 */
$auth = get_module_ini('settings_allow_edit');
$_INSTALL['MAIN_MENU_ITEM'] = array (
    'title' => 'settings_looks',
    'url' => '/settings/index',
    'auth' => 'admin',
    'module_name' => 'settings',
    'parent' => 0,
    'weight' => 3,
    'admin_only' => true,
    'section' => 'settings'
);

$_INSTALL['VERSION'] = 1.31;

$_INSTALL['PUBLIC_CLONE_URL'] = 'git://github.com/diversen/settings.git';
$_INSTALL['PRIVATE_CLONE_URL'] = 'git@github.com:diversen/settings.git';

