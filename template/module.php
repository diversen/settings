<?php

/**
 * model file for settings/template
 *
 * @package settings
 */
view::includeOverrideFunctions('settings', 'template/views.php' );
 /**
  * template class
  *
  * @package    settings
  */
class settings_template extends db {

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
    public function updateTemplate (){

        $values = 
            array('template'=> $_POST['template'], 'css' => NULL);
        $res = $this->update('settings', $values, 1);
        return $res;

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
        $template_path = conf::pathHtdocs() . '/templates';
        $rows = array();
                
        // TODO: speed up
        $list = file::getFileListRecursive($template_path);
        foreach ($list as $val) {
            $info = pathinfo($val);
            if ($info['basename'] != 'template.inc') continue;
            $row = array ();
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
    public static function getAllCss(){
        $db = new db();
        $row = self::getTemplate();
        $template = $row['template'];

        $template_path = conf::pathHtdocs() . "/templates/$template";
        $dir = dir($template_path);
        $rows = array();
        while (false !== ($entry = $dir->read())) {
            if ($entry == '.') continue;
            if ($entry == '.git') continue;
            if ($entry == '..') continue;

            $css_dir = $template_path . "/$entry";
            $valid_css_file = $css_dir . "/$entry.css";
            if (is_dir($css_dir) && file_exists($valid_css_file)){
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