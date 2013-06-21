<?php

http::prg();

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

template::setTitle(lang::translate('Edit Template Css'));

if (isset($_POST)) $_POST = html::specialEncode ($_POST);

$t = new settings_template();
$values = $t->getCss('update');

if (isset($_POST['css'])){
    $t->validateCss();
    if (empty($t->errors)){
        $t->updateCss();
        session::setActionMessage(lang::translate('settings_css_updated'));
        http::locationHeader('/settings/template/css');
    }
} else {
    view_update_css($values);
    $t->getCss();
}

