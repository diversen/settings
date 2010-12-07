<?php

/**
 * view functions for settings/menu
 *
 * @package settings
 */
if (!session::checkAccessControl('allow_edit_settings')){
    return;
}

template::setTitle(lang::translate('Menu Order'));
$menu = new menus();
$list = $menu->getMenuList();

$menu->validateOrder();
if (empty($menu->error) && isset($_POST['submit'])){
    $menu->updateMenuList();
    header( 'Location: /settings/menu/order' );
}

if (isset($_POST['order'])){
    if(isset($menu->error)){
        view_form_errors($menu->error);
    }
}
view_order_list($list);