<?php

/**
 * controller file settings/menu/index
 *
 * @package     settings
 */
 
if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

$mod = new menus();
template::setTitle(lang::translate('Menus'));
$mod->getAllMenuModules();
$enabled = $mod->getEnabledModules();