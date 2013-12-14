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

moduleloader::includeModule('settings');
$options = array (
    'page_title' => lang::translate('settings_favicon_title'), 
    'redirect' => '/settings/favicon/index', 
    'db_table' => 'settings',
    'db_column' => 'background',
    'filename' => 'background',
    'save_path' => '/background',
    'mimetypes' => array (
        'x-icon' => 'image/x-icon',
        'icon' => 'image/vnd.microsoft.icon',
        
    )
);

template::getFaviconHTML();
image_form::imageFormController($options);
