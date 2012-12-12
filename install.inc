<?php

$_INSTALL['MAIN_MENU_ITEMS'][] = array (
    'title' => 'settings_looks',
    'url' => '/settings/index',
    'auth' => 'admin',
    'module_name' => 'settings',
    'parent' => 0,
    'weight' => 3,
    'admin_only' => true,
    'section' => 'settings'
);

$_INSTALL['MAIN_MENU_ITEMS'][] = array (
    'title' => 'settings_mail',
    'url' => '/settings/mail/index',
    'auth' => 'admin',
    'module_name' => 'settings',
    'parent' => 0,
    'weight' => 3,
    'admin_only' => true,
    'section' => 'settings'
);

$_INSTALL['VERSION'] = 1.70;

$_INSTALL['PUBLIC_CLONE_URL'] = 'git://github.com/diversen/settings.git';
$_INSTALL['PRIVATE_CLONE_URL'] = 'git@github.com:diversen/settings.git';

