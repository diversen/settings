<?php

if (!session::checkAccessControl('allow_edit_settings')){
    return;
}

settings_view_titles();
if (isset($_POST['submit'])){
    $menu = new menus();
    $menu->updateMenuTitles ();
    session::setActionMessage(lang::translate('settings_menu_titles_updated'));
    header("Location: /settings/menu/titles");
}
