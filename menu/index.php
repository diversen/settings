<?php

/**
 * controller file settings/menu/index
 *
 * @package     settings
 */
 
if (!session::checkAccessFromModuleIni('settings_allow_edit')){
    return;
}

if (isset($_POST)) $_POST = html::specialEncode ($_POST);

$mod = new settings_menu();
template::setTitle(lang::translate('Menus'));
$mod->getAllMenuModules();
$enabled = $mod->getEnabledModules();