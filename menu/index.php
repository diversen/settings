<?php

/**
 * controller file settings/menu/index
 *
 * @package     settings
 */
 
if (!session::checkAccessControl('allow_edit_settings')){
    return;
}

$mod = new menus();
template::setTitle(lang::translate('Menus'));
$mod->getAllMenuModules();
$enabled = $mod->getEnabledModules();