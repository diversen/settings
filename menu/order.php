<?php

/**
 * view functions for settings/menu
 *
 * @package settings
 */
if (!session::checkAccessFromModuleIni('settings_allow_edit')){
    return;
}

template::setTitle(lang::translate('Menu Order'));
$menu = new settings_menu();
$list = $menu->getMenuList();

$menu->validateOrder();
if (empty($menu->error) && isset($_POST['submit'])){
    $menu->updateMenuList();
    header( 'Location: /settings/menu/order' );
    exit;
}

if (isset($_POST['order'])){
    if(isset($menu->error)){
        html::errors($menu->error);
    }
}
view_order_list($list);