<?php

/**
 * controller file settings/template/index
 *
 * @package settings
 */
if (!session::checkAccessControl('allow_edit_settings')){
    return;
}

template::setTitle(lang::translate('Edit Template'));

$t = new templateManip();
$values = $t->getTemplate('update');

if (isset($_POST['template'])){
    $t->validateTemplate();
    if (empty($t->errors)){
        $t->updateTemplate();
        header( 'Location: /settings/template/index' );
    } 
} else {
    view_update_template($values);
    $t->getTemplates();  
}
