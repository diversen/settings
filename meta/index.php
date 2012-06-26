<?php

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

$m = new settingsMeta();
$m->form();

if (isset($_POST['robots_submit'])) {
    if (empty($m->errors)) {
        $m->update();
        session::setActionMessage(lang::translate('settings_meta_updated_action'));
        http::locationHeader('/settings/meta/index');
    }
}