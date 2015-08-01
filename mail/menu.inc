<?php

use diversen\lang;
/**
 * Main menu file for settings
 *
 * @package     settings
 */

$_MODULE_MENU = array (
    
    array(
        'title' => lang::translate('settings: menu mail system mail'),
        'url' => '/settings/mail/system',
        'auth' => 'admin'
    ),
    
    array(
        'title' => lang::translate('settings: menu mail method'),
        'url' => '/settings/mail/index',
        'auth' => 'admin'
    ),
    
    array(
        'title' => lang::translate('settings: menu mail params'),
        'url' => '/settings/mail/params',
        'auth' => 'admin'
    ),

    

);
