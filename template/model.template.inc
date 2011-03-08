<?php

/**
 * model file for settings/template
 *
 * @package settings
 */

 /**
  * template class
  *
  * @package    settings
  */
class templateManip extends db {

    /**
     *
     * @var array   errors
     */
    public $errors = array();

    /**
     * method for getting current template from db
     *
     * @return array> row containing settings
     */
    public static function getTemplate($state = NULL){
        $db = new db();
        $row = $db->selectOne('settings', 'id', 1);
        return $row;
    }

    /**
     * method for getting current css from db
     *
     * @return array> row containing settings
     */
    public static function getCss($state = NULL){
        $db = new db();
        $row = $db->selectOne('settings', 'id', 1);
        return $row;
    }

    /**
     * method for validating form submission
     * Validate user input
     */    
    public function validateCss(){

    }

    /**
     * method for validating form submission
     * Validate user input
     */
    public function validateTemplate(){

    }


    /**
     * method for updating template in db
     *
     * @return boolean  true on success or false on failure
     */
    public function updateTemplate (){
        try {
            $values = 
                array('template'=> $_POST['template'], 'css' => NULL);
            $res = $this->update('settings', $values, 1);
            return $res;
        } catch (PDOException $e) {
            $this->fatalError($e->getMessage());
        }
    }


    /**
     * method for updating template in db
     *
     * @return boolean  true on success or false on failure
     */
    public function updateCss (){

            $values =
                array('css'=> $_POST['css']);

            $res = $this->update('settings', $values, 1);
            return $res;

    }
    
    /**
     * method for getting template found in templates dir
     *
     * @return array values for populating dropdown function view_drop_down
     */
    public static function getTemplates(){
        $template_path = _COS_PATH . '/htdocs/templates';
        $dir = dir($template_path);
        $rows = array();
        while (false !== ($entry = $dir->read())) {
            if ($entry == '.') continue;
            if ($entry == '..') continue;

            $template_file = $template_path . "/$entry/template.inc";
            if (!file_exists($template_file)) continue;

            $row['id'] = $entry;
            $row['title'] = $entry;
            $rows[] = $row;

        }
        $dir->close();
        return $rows;
    }

    /**
     * method for getting template found in templates dir
     *
     * @return array values for populating dropdown function view_drop_down
     */
    public static function getAllCss(){
        $db = new db();
        $row = self::getTemplate();
        $template = $row['template'];

        $template_path = _COS_PATH . "/htdocs/templates/$template";
        $dir = dir($template_path);
        $rows = array();
        while (false !== ($entry = $dir->read())) {
            if ($entry == '.') continue;
            if ($entry == '.git') continue;
            if ($entry == '..') continue;

            $css_dir = $template_path . "/$entry";
            if (is_dir($css_dir)){
                $row['id'] = $entry;
                $row['title'] = $entry;
                $rows[] = $row;
                continue;
            }

            if (!strstr($entry, "common")){
                continue;
            }
            if (!strstr($entry, "css")){
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