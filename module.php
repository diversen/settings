<?php

namespace modules\settings;

use diversen\lang;
use diversen\session;
use diversen\template;

class module {

    public function indexAction() {
        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }
        template::setTitle(lang::translate('Site Settings'));
        echo lang::translate('Site Settings');
    }
}
