<?php

use diversen\conf;
use diversen\lang;

$_INSTALL['MAIN_MENU_ITEMS'][] = array (
    'title' => lang::translate('Look and feel', null ,array ('no_translate' => true)),
    'url' => '/settings/index',
    'auth' => conf::getModuleIni('settings_allow_edit'),
    'module_name' => 'settings',
    'parent' => 0,
    'weight' => 3,
    'admin_only' => true,
    'section' => 'settings'
);

if (conf::getModuleIni('settings_allow_email')) {
    $_INSTALL['MAIN_MENU_ITEMS'][] = array (
        'title' => lang::translate('SMTP Mail', null ,array ('no_translate' => true)),
        'url' => '/settings/mail/index',
    'auth' => conf::getModuleIni('settings_allow_edit'),
        'module_name' => 'settings',
        'parent' => 0,
        'weight' => 3,
        'admin_only' => true,
        'section' => 'settings'
    );
}

$_INSTALL['VERSION'] = 4.01;

$_INSTALL['PUBLIC_CLONE_URL'] = 'git://github.com/diversen/settings.git';
$_INSTALL['PRIVATE_CLONE_URL'] = 'git@github.com:diversen/settings.git';

