<?php

/**
 * Main model file for settings/logo
 *
 * @package     settings
 */

/**
 * main class for settings/logo
 *
 * @package     settings
 */
class logo {

    /**
     * var holding errors
     * @var array   $errors
     */
    public $errors = array();
    
    /**
     * var holding options
     * @var array $options
     */
    public $options = array (
        'db_column' => 'logo',
        'db_table' => 'settings');
    
    /**
     * var holding table name
     * @var string $db_table
     */
    public $db_table = null;
    
    /**
     * var holding db_column
     * @var string $db_column 
     */
    public $db_column = null;
    /**
     * constructs object
     * @param array $options 
     */
    public function __construct($options = array ()) {
        if (!empty($options)) {
            $this->options = $options;
        }
        $this->db_table = $this->options['db_table'];
        $this->db_column = $this->options['db_column'];
    }

    /**
     * method for updating image file
     * @param string $filename
     * @return boolean $res true on success and false on failure.  
     */
    public function updateLogo ($filename = 'logo'){
        $db = new db();
        $values = array(
            $this->db_column => $_FILES[$filename]['name']);
            // so far only first row of settings table is populated
            //therefor:  id = 1
        $res = $db->update($this->db_table, $values, 1);
        return $res;
    }

    /**
     * method for uploading and moving a image
     * @param string $filename the $_FILES['name']
     * @param string $path the relative path, e.g. '/logo'
     * @return int $int 1 on success and 0 on failure 
     */
    public function moveFile($filename = 'logo', $path = '/logo'){
        if(empty($_FILES[$filename]['name'])) {
            $this->errors[] = lang::translate('settings_upload_no_file_specified');
            return 0;
        }
        
        $valid_types = array ();
        $valid_types[] = "image/gif";
        $valid_types[] = "image/jpeg";
        $valid_types[] = "image/pjpeg";
        $valid_types[] = "image/png";
        
        if (!in_array($_FILES[$filename]['type'], $valid_types)) {
            $this->errors[] = lang::translate('settings_upload_wrong_filetype_specified');
            return 0;
        }
                      
        $uploaddir = config::getFullFilesPath() . $path;
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir);
        }
        
        $uploadfile = $uploaddir . '/' . basename($_FILES[$filename]['name']);
        $this->unlinkFile();
        if (isset($_FILES[$filename])){
            if (move_uploaded_file($_FILES[$filename]['tmp_name'], $uploadfile)) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    /**
     * method for unlinking a file
     *
     * @return boolean  true on success or false on failure
     */
    public function unlinkFile($path = '/logo'){
        $db = new db();
        $uploaddir = config::getFullFilesPath() . $path;
        $row = $db->selectOne($this->db_table, 'id', 1);
        if (empty($row[$this->db_column])){
            return false;
        }
        $unlinkfile = $uploaddir . '/' . $row[$this->db_column];
        if ($this->getLogoFile('/logo')){
            return unlink($unlinkfile);
        } else {
            return false;
        }
    }

    /**
     * method for getting logo file
     * @return boolean $res true on success or false on failure
     */
    public function getLogoFile($path = '/logo'){
        $db = new db();
        $uploaddir = config::getFullFilesPath() . $path;
        $row = $db->selectOne($this->db_table, 'id', 1);
        if (empty($row[$this->db_column])){
            return false;
        }
        $unlinkfile = $uploaddir . '/' . $row[$this->db_column];
        return $unlinkfile;
    }


    /**
     * method for deleting logo in db table
     * @return  boolean true on success or false on failure
     */
    function deleteLogoDb(){
        $db = new db();
        $values =
            array($this->db_column => '');
        // so far only first row of settings table is populated
        $res = $db->update($this->db_table, $values, 1);
        return $res;
    }
}
