<?php

use diversen\conf;
use diversen\session;
use diversen\lang;
/**
 * Main model file for settings/logo
 *
 * @package     settings
 */
/**
 * @ignore
 */
include_once conf::getModulePath('settings') . "/lib/image_form.inc";

/**
 * main class for settings/logo
 *
 * @package     settings
 */
class settings_logo extends image_form {

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

        image_form::imageFormController($options);
    }

}
