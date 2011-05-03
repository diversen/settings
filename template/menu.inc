<?php

/**
 * @ignore
 */
$auth = get_module_ini('settings_allow_edit');
$_SUB_MODULE_MENU = array (
    array(
        'title' => lang::translate('Set template'),
        'url' => '/settings/template/index',
        'auth' => $auth
    ),
    array(
        'title' => lang::translate('Template Style'),
        'url' => '/settings/template/css',
        'auth' => $auth
    ),
);