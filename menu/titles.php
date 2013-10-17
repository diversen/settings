<?php

if (!session::checkAccessFromModuleIni('settings_allow_edit')){
    return;
}

settings_view_titles();
if (isset($_POST['submit'])){
    $menu = new settings_menu();
    $menu->updateMenuTitles ();
    session::setActionMessage(lang::translate('settings_menu_titles_updated'));
    header("Location: /settings/menu/titles");
    exit;
}
