<?php

/**
 * controller file settings/logo/index
 *
 * @package     settings
 */

if (!session::checkAccessControl('allow_edit_settings')){
    return;
}

template::setTitle(lang::translate('Edit Logo'));
$logo = new logo();


if (!empty($_POST['submit'])){
    if (!$logo->moveFile()){
        view_form_errors($logo->errors);
        view_create();
        if ($logo->logoExist()){
            view_delete();
        }
    } else {
        $logo->updateLogo();
        header( 'Location: /settings/logo/index' );
    }    
} else if (!empty($_POST['delete'])){
    $logo->unlinkFile();
    $logo->deleteLogoDb();
    header( 'Location: /settings/logo/index' );
} else {
    view_create();
    if ($logo->logoExist()){
        view_delete();
    }
}