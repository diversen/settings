<?php

/**
 * controller file for settings/text
 *
 * @package settings
 */

if (!session::checkAccessControl('allow_edit_settings')){
    return;
}
template::setTitle(lang::translate('Set Misc Settings'));
$settings = new settings();
if (isset($_POST['submit'])){
    
    if ($settings->validate()){

        $settings->updateText();
        view_confirm(lang::translate('New settings has been saved'));
    } else {
        view_form_errors($settings->errors);
        view_update_text();
    }
} else {
    $row = $settings->getSettings();
    view_update_text($row);
}