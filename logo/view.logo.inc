<?php

/**
 * Main view file for settings/logo
 *
 * @package     settings
 */

/**
 * function for viewing logo form
 */
function view_settings_logo_form ($options = array ()){ 
    print_r($options);
    $vars = array (
        'legend' => lang::translate('Edit Logo'),
        'label_logo_file' => lang::translate('Logo file'),
        'filename' => $options['filename'],
    );
    echo view::get('settings', 'logo_upload', $vars);

}

/**
 * function for viewing delete logo
 */
function view_settings_logo_delete (){ 
    $vars = array (
        'logo_delete_legend' => lang::translate('Delete Logo'),
        'logo_delete_submit' => lang::translate('Delete Current Logo'),
    );
    echo view::get('settings', 'logo_delete', $vars);
}