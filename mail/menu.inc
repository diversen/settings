<?php

use diversen\lang;
/**
 * Main menu file for settings
 *
 * @package     settings
 */

$_MODULE_MENU = array (
    
    array(
        'title' => lang::translate('System email'),
        'url' => '/settings/mail/system',
        'auth' => 'admin'
    ),
    
    array(
        'title' => lang::translate('Mail method'),
        'url' => '/settings/mail/index',
        'auth' => 'admin'
    ),
    
    array(
        'title' => lang::translate('Mail params'),
        'url' => '/settings/mail/params',
        'auth' => 'admin'
    ),

    

);
