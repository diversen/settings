<?php

use diversen\conf;
use diversen\lang;
use diversen\moduleloader;
use diversen\session;
use diversen\template;

include_once conf::getModulePath('settings') . "/lib/image_form.php";

class settings_favicon extends image_form {

    public function indexAction() {
        if (!session::authIni('settings_allow_edit')) {
            return;
        }

        moduleloader::includeModule('settings');
        $options = array(
            'page_title' => lang::translate('Favicon settings'),
            'redirect' => '/settings/favicon/index',
            'db_table' => 'settings',
            'db_column' => 'favicon',
            'filename' => 'favicon',
            'save_path' => '/favicon',
            'mimetypes' => array(
                'x-icon' => 'image/x-icon',
                'icon' => 'image/vnd.microsoft.icon',
            )
        );

        template::getFaviconHTML();
        image_form::imageFormController($options);
    }

}
