<?php

if (!session::checkAccessControl('settings_allow_edit')){
    return;
}

template::setTitle(lang::translate('Site Settings'));
print lang::translate('Site Settings');