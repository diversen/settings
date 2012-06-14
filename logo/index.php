<?php

/**
 * controller file settings/logo/index
 *
 * @package     settings
 */

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

$options = array (
    'page_title' => lang::translate('Edit Logo'), 
    'redirect' => '/settings/logo/index', 
    'db_table' => 'settings',
    'db_column' => 'logo',
    'filename' => 'logo'
);

template::setTitle($options['page_title']);
$logo = new logo();
if (!empty($_POST['submit'])){
    if (!$logo->moveFile('logo', '/logo')){
        view_form_errors($logo->errors);
        view_settings_logo_form($options);
        if ($logo->getLogoFile('/logo')){
            view_settings_logo_delete($options);
        }
    } else {
        $logo->updateLogo();
        http::locationHeader( $options['redirect'] );
    }    
} else if (!empty($_POST['delete'])){
    $logo->unlinkFile();
    $logo->deleteLogoDb();
    http::locationHeader( $options['redirect']);
} else {
    view_settings_logo_form($options);
    if ($logo->getLogoFile('/logo')){
        view_settings_logo_delete($options);
    }
}