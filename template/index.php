<?php

http::prg();

if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
    return;
}

template::setTitle(lang::translate('Edit Template'));

$t = new settings_template();
$values = $t->getTemplate('update');

if (isset($_POST)) {
    $_POST = html::specialEncode($_POST);
}

if (isset($_POST['template'])) {
    $t->validateTemplate();
    if (empty($t->errors)) {
        $t->updateTemplate();
        session::setActionMessage(lang::translate('settings_template_updated'));
        http::locationHeader('/settings/template/index');
    }
}

if (!empty($t->errors)) {
    echo html::getErrors($t->errors);
}
settings_template($values);
$t->getTemplates();
return;
