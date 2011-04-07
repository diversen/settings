<?php

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

template::setTitle(lang::translate('Edit Template Css'));

$t = new templateManip();
$values = $t->getCss('update');


if (isset($_POST['css'])){
    $t->validateCss();
    if (empty($t->errors)){
        $t->updateCss();
        session::setActionMessage(lang::translate('settings_css_updated'));
        header( 'Location: /settings/template/css' );
    }
} else {
    view_update_css($values);
    $t->getCss();
}

