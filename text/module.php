<?php

/**
 * model file for sub module settings/text
 *
 * @package settings
 */

/**
 * main class for settings/text
 *
 * @package settings
 */
class settings_text extends db {

    /**
     *
     * @var array   errors
     */
    public $errors = array();

    /**
     * method for getting settings
     *
     * @return array  row containing the settings
     */
    public function getSettings(){
        $row = $this->selectOne('settings', 'id', 1);
        return $row;
    }

    /**
     * method for validating user input
     * 
     * @return  int  1 on success or 0 on failure
     */    
    function validate(){
    // no validation for now
        return 1;

    }

    /**
     * method for updating text
     *
     * @return boolean  true on success and false on failure
     */
    public function updateText (){
            $db = new db();
            $values = 
                array(
                      'footer_message' => $_POST['footer_message'],
                      'description' => $_POST['description']
                      );


            $res = $db->update('settings', $values, 1);
            return $res;
        
    }
}