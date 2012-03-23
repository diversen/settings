<?php

/**
 * controller file settings/menu/index
 *
 * @package     settings
 */
 
if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

if (isset($_POST)) $_POST = html::specialEncode ($_POST);

$mod = new menus();
template::setTitle(lang::translate('Menus'));
$mod->getAllMenuModules();
$enabled = $mod->getEnabledModules();