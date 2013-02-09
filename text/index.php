<?php

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

template::setTitle(lang::translate('Set Misc Settings'));
$settings = new settings();
if (isset($_POST['submit'])){
    
    if ($settings->validate()){

        $settings->updateText();
        html::confirm(lang::translate('New settings has been saved'));
    } else {
        html::errors($settings->errors);
        view_update_text();
    }
} else {
    $row = $settings->getSettings();
    view_update_text($row);
}