<?php

use diversen\session;
use diversen\template;
use diversen\lang;
class settings {

    public function indexAction() {
        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        template::setTitle(lang::translate('Site Settings'));
        echo lang::translate('Site Settings');
    }

}
