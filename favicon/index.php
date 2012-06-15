<?php

/**
 * controller file settings/logo/index
 *
 * @package     settings
 */

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}
//print_r($_FILES); die;

$options = array (
    'page_title' => lang::translate('settings_favicon_title'), 
    'redirect' => '/settings/favicon/index', 
    'db_table' => 'settings',
    'db_column' => 'favicon',
    'filename' => 'favicon',
    'save_path' => '/favicon',
    'mimetypes' => array (
        'x-icon' => 'image/x-icon',
        'icon' => 'image/vnd.microsoft.icon',
        
    )
);


image_form::imageFormController($options);
