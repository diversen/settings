<?php

/**
 * Main menu file for settings
 *
 * @package     settings
 */

$_MODULE_MENU = array (
    array(
        'title' => lang::translate('Change Logo'),
        'url' => '/settings/logo/index',
        'auth' => 'admin'
    ),
    
    array(
        'title' => lang::translate('settings_menu_favicon'),
        'url' => '/settings/favicon/index',
        'auth' => 'admin'
    ),

    array(
        'title' => lang::translate('Set template'),
        'url' => '/settings/template/index',
        'auth' => 'admin',
    ),
    
    array(
        'title' => lang::translate('Edit Template Css'),
        'url' => '/settings/template/css',
        'auth' => 'admin',
    ),
);
