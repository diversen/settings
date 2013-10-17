<?php

if (!session::checkAccessFromModuleIni('settings_allow_edit')){
    return;
}

template::setTitle(lang::translate('Site Settings'));
echo lang::translate('Site Settings');
