<?php

namespace modules\settings\favicon; 
use diversen\conf;
use diversen\lang;
use diversen\moduleloader;
use diversen\session;
use diversen\template;

use modules\settings\lib\module as image_form;
//include_once conf::getModulePath('settings') . "/lib/image_form.php";

class module extends image_form {

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

        image_form::imageFormController($options);
    }

}
