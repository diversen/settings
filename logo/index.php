<?php

//http::prg();
/**
 * controller file settings/logo/index
 *
 * @package     settings
 */

if (!session::checkAccessFromModuleIni('settings_allow_edit')){
    return;
}

$options = array (
    'page_title' => lang::translate('Edit Logo'), 
    'redirect' => '/settings/logo/index', 
    'db_table' => 'settings',
    'db_column' => 'logo',
    'filename' => 'logo',
    'save_path' => '/logo',
);

image_form::imageFormController($options);
