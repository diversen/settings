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
    /*
    array(
        'title' => lang::translate('Edit Misc Settings'),
        'url' => '/settings/text/index',
        'auth' => 'admin'
    ),*/
    array(
        'title' => lang::translate('Set template'),
        'url' => '/settings/template/index',
        'auth' => 'admin',
    ),
    /*
    array(
        'title' => lang::translate('Menu Order'),
        'url' => '/settings/menu/order',
        'auth' => 'admin'
    ),*/
);