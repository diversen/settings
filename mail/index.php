<?php

if (!config::getModuleIni('settings_allow_email')) {
    moduleloader::setStatus(403);
    return;
}

if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
    return;
}

layout::disableMainModuleMenu();

$m = new settings_mail();

if (!empty($_POST)) {
    $_POST = html::specialEncode($_POST);
    $m->validateMethod();
    if (empty($m->errors)) {
        $res = $m->updateMethod();
        if ($res) {
            $message = lang::translate('settings: action message: mail method updated');
            http::locationHeader('/settings/mail/index', $message);
        }
    }
} 

$m->mailFormMethod();
