<?php

namespace modules\settings\template;

use diversen\conf;
use diversen\db;
use diversen\file;
use diversen\html;
use diversen\http;
use diversen\lang;
use diversen\session;
use diversen\template;
use diversen\view;

use modules\settings\template\views;
/**
 * model file for settings/template
 *
 * @package settings
 */
view::includeOverrideFunctions('settings', 'template/views.php');

/**
 * template class
 *
 * @package    settings
 */
class module {

    /**
     *
     * @var array   errors
     */
    public $errors = array();

    public function indexAction() {
        http::prg();

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        template::setTitle(lang::translate('Edit Template'));

        $t = new self();
        $values = $t->getTemplate('update');

        if (isset($_POST)) {
            $_POST = html::specialEncode($_POST);
        }

        if (isset($_POST['template'])) {
            $t->validateTemplate();
            if (empty($t->errors)) {
                $t->updateTemplate();
                session::setActionMessage(lang::translate('Template has been updated'));
                http::locationHeader('/settings/template/index');
            }
        }

        if (!empty($t->errors)) {
            echo html::getErrors($t->errors);
        }
        views::settings_template($values);
        $t->getTemplates();
        return;
    }

    public function cssAction() {
        http::prg();

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        template::setTitle(lang::translate('Edit Template Css'));

        if (isset($_POST))
            $_POST = html::specialEncode($_POST);

        //$t = new self();
        $values = self::getCss('update');

        if (isset($_POST['css'])) {
            $this->validateCss();
            if (empty($t->errors)) {
                $this->updateCss();
                session::setActionMessage(lang::translate('CSS settings has been updated'));
                http::locationHeader('/settings/template/css');
            }
        } else {
            views::settings_update_css($values);
            self::getCss();
        }
    }

    /**
     * method for getting current template from db
     *
     * @return array> row containing settings
     */
    public static function getTemplate($state = NULL) {
        $db = new db();
        $row = $db->selectOne('settings', 'id', 1);
        return $row;
    }

    /**
     * method for getting current css from db
     *
     * @return array> row containing settings
     */
    public static function getCss($state = NULL) {
        $db = new db();
        $row = $db->selectOne('settings', 'id', 1);
        return $row;
    }

    /**
     * method for validating form submission
     * Validate user input
     */
    public function validateCss() {
        
    }

    /**
     * method for validating form submission
     * Validate user input
     */
    public function validateTemplate() {
        if ($_POST['template'] == '0') {
            $this->errors[] = lang::translate('Select a template');
            return;
        }
    }

    /**
     * method for updating template in db
     *
     * @return boolean  true on success or false on failure
     */
    public function updateTemplate() {
        $db = new db();
        $values = array('template' => $_POST['template'], 'css' => NULL);
        $res = $db->update('settings', $values, 1);
        return $res;
    }

    /**
     * method for updating template in db
     *
     * @return boolean  true on success or false on failure
     */
    public function updateCss() {
         $db = new db();
        $values = array('css' => $_POST['css']);

        $res = $db->update('settings', $values, 1);
        return $res;
    }

    /**
     * method for getting template found in templates dir
     *
     * @return array values for populating dropdown function view_drop_down
     */
    public static function getTemplates() {
        $template_path = conf::pathHtdocs() . '/templates';
        $rows = array();

        // TODO: speed up
        $list = file::getFileListRecursive($template_path);
        foreach ($list as $val) {
            $info = pathinfo($val);
            if ($info['basename'] != 'template.php')
                continue;
            $row = array();
            $row['id'] = $template = str_replace($template_path . '/', '', $info['dirname']);
            $row['title'] = $template;
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * method for getting template found in templates dir
     *
     * @return array values for populating dropdown function view_drop_down
     */
    public static function getAllCss() {
        $db = new db();
        $row = self::getTemplate();
        $template = $row['template'];

        $template_path = conf::pathHtdocs() . "/templates/$template";
        $dir = dir($template_path);
        $rows = array();
        while (false !== ($entry = $dir->read())) {
            if ($entry == '.')
                continue;
            if ($entry == '.git')
                continue;
            if ($entry == '..')
                continue;

            $css_dir = $template_path . "/$entry";
            $valid_css_file = $css_dir . "/$entry.css";
            if (is_dir($css_dir) && file_exists($valid_css_file)) {
                $row['id'] = $entry;
                $row['title'] = $entry;
                $rows[] = $row;
                continue;
            }

            if (!strstr($entry, "common")) {
                continue;
            }
            if (!strstr($entry, "css")) {
                continue;
            }

            $row['id'] = $entry;
            $row['title'] = $entry;
            $rows[] = $row;
        }
        $dir->close();
        return $rows;
    }

}
