<?php

if (!config::getModuleIni('settings_allow_email')) {
    moduleloader::setStatus(403);
    return;
}

if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
    return;
}

layout::disableMainModuleMenu();

$_POST = html::specialEncode($_POST);
$method = config::getMainIni('mail_method');

//echo lang::translate('settings: mail current method is') . " ";
//echo $method;

$m = new settings_mail();

if ($method == 'smtp') { 
    if (isset($_POST['smtp_submit'])) {
        $m->validateSMTP();
        if (empty($m->errors)) {
            $res = $m->updateSMTP();
            if ($res) {
                $message = lang::translate('settings: action message: smtp updated');
                http::locationHeader('/settings/mail/params', $message);
            }
        } else {
            html::errors($m->errors);
        }
    }
    $m->mailFormSMTP();
    
}

if ($method == 'sendmail') { 
    if (isset($_POST['sendmail_submit'])) {
        if (empty($m->errors)) {
            $res = $m->updateSendmail();
            if ($res) {
                $message = lang::translate('settings: action message: sendmail updated');
                http::locationHeader('/settings/mail/params', $message);
            }
        } 
    }
    $m->mailFormSendmail();   
}

if ($method == 'mail') { 
    if (isset($_POST['mail_submit'])) {
        if (empty($m->errors)) {
            $res = $m->updateMail();
            if ($res) {
                $message = lang::translate('settings: action message: smtp updated');
                http::locationHeader('/settings/mail/params', $message);
            }
        } 
    }
    $m->mailFormMail();   
}