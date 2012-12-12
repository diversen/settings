<?php

if (!config::getModuleIni('settings_allow_email')) {
    moduleloader::setStatus(403);
    return;
}

if (!session::checkAccessControl('settings_allow_edit')) {
    return;
}

layout::disableMainModuleMenu();

$m = new settingsMail();
if (isset($_POST['site_email_submit'])) {
    if (empty($m->errors)) {
        $res = $m->updateSiteEmail();
        if ($res) {
            $message = lang::translate('settings: action message: site email updated');
            http::locationHeader('/settings/mail/system', $message);
        }
    } 
}
$m->mailFormSiteEmail();   
