<?php

use diversen\conf;
use diversen\lang;
use diversen\moduleloader;
use diversen\session;
use diversen\template;

/**
 * @ignore
 */
include_once conf::getModulePath('settings') . "/lib/image_form.php";

class settings_favicon extends image_form {

    public function indexAction() {

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        moduleloader::includeModule('settings');
        $options = array(
            'page_title' => lang::translate('Favicon settings'),
            'redirect' => '/settings/favicon/index',
            'db_table' => 'settings',
            'db_column' => 'background',
            'filename' => 'background',
            'save_path' => '/background',
            'mimetypes' => array(
                'x-icon' => 'image/x-icon',
                'icon' => 'image/vnd.microsoft.icon',
            )
        );

        template::getFaviconHTML();
        image_form::imageFormController($options);
    }
}
