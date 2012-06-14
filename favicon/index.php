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
    'page_title' => lang::translate('Edit favicon'), 
    'redirect' => '/settings/favicon/index', 
    'db_table' => 'settings',
    'db_column' => 'favicon',
    'filename' => 'favicon'
);

template::setTitle($options['page_title']);
$logo = new logo();
if (!empty($_POST['submit'])){
    if (!$logo->moveFile('favicon', '/favicon')){
        view_form_errors($logo->errors);
        view_settings_logo_form($options);
        if ($logo->getLogoFile('/favicon')){
            view_settings_logo_delete($options);
        }
    } else {
        $logo->updateLogo();
        http::locationHeader( $options['redirect'] );
    }    
} else if (!empty($_POST['delete'])){
    $logo->unlinkFile('/favicon');
    $logo->deleteLogoDb();
    http::locationHeader( $options['redirect']);
} else {
    view_settings_logo_form($options);
    if ($logo->getLogoFile('/favicon')){
        view_settings_logo_delete($options);
    }
}
