<?php

namespace modules\settings\logo;

use diversen\lang;
use diversen\session;

use modules\settings\lib\module as image_form;
/**
 * @ignore
 */
//include_once conf::getModulePath('settings') . "/lib/image_form.php";

/**
 * @package     settings
 */
class module extends image_form {

    public function indexAction() {

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        $options = array(
            'page_title' => lang::translate('Edit Logo'),
            'redirect' => '/settings/logo/index',
            'db_table' => 'settings',
            'db_column' => 'logo',
            'filename' => 'logo',
            'save_path' => '/logo',
        );

        self::imageFormController($options);
    }
}
