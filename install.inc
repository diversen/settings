<?php

$_INSTALL['MAIN_MENU_ITEMS'][] = array (
    'title' => lang::translate('Menu: settings_looks', null ,array ('no_translate' => true)),
    'url' => '/settings/index',
    'auth' => 'admin',
    'module_name' => 'settings',
    'parent' => 0,
    'weight' => 3,
    'admin_only' => true,
    'section' => 'settings'
);

if (config::getModuleIni('settings_allow_email')) {
    $_INSTALL['MAIN_MENU_ITEMS'][] = array (
        'title' => lang::translate('Menu: settings_mail', null ,array ('no_translate' => true)),
        'url' => '/settings/mail/index',
        'auth' => 'admin',
        'module_name' => 'settings',
        'parent' => 0,
        'weight' => 3,
        'admin_only' => true,
        'section' => 'settings'
    );
}

$_INSTALL['VERSION'] = 2.41;

$_INSTALL['PUBLIC_CLONE_URL'] = 'git://github.com/diversen/settings.git';
$_INSTALL['PRIVATE_CLONE_URL'] = 'git@github.com:diversen/settings.git';

