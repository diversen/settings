<?php

/**
 * Main model file for settings/logo
 *
 * @package     settings
 */

/**
 * main class for settings/logo
 *
 * @todo    make a uploader class
 * @package     settings
 */
class logo extends db {

    /**
     *
     * @var array   holding errors
     */
    public $errors = array();

    /**
     *
     * method for updating logo

     * @return <int> 1 on succes or 0 on failure
     */
    public function updateLogo (){
        try {
            $values = 
                array('logo'=> $_FILES['logo']['name']);
            // so far only first row of settings table is populated
            $res = $this->update('settings', $values, 1);
            return $res;
        } catch (PDOException $e) {
            $this->fatalError($e->getMessage());
        }
    }

    /**
     * method for moving uploaded file
     *
     * @return int  1 on success or 0 on failure
     */
    public function moveFile(){
        if(empty($_FILES['logo']['name'])) {
            $this->errors[] = lang::translate('settings_upload_no_file_specified');
            return 0;
        }
        
        $valid_types[] = "image/gif";
        $valid_types[] = "image/jpeg";
        $valid_types[] = "image/pjpeg";
        $valid_types[] = "image/png";
        
        if (!in_array($_FILES['logo']['type'], $valid_types)) {
            echo $_FILES['logo']['name']['type'];
            print_r($_FILES);
            $this->errors[] = lang::translate('settings_upload_no_file_specified');
            echo "bla";
            return 0;
        }
        
        
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/logo/";
        $uploadfile = $uploaddir . basename($_FILES['logo']['name']);
        $this->unlinkFile();
        if (isset($_FILES['logo'])){
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
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
    public function unlinkFile(){
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/logo/";
        $row = $this->selectOne('settings', 'id', 1);
        if (empty($row['logo'])){
            return false;
        }
        $unlinkfile = $uploaddir . $row['logo'];
        if ($this->logoExist()){
            return unlink($unlinkfile);
        } else {
            return false;
        }
    }

    /**
     * method for getting logo file
     *
     * @return boolean  true on success or false on failure
     */
    public function getLogoFile(){
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/logo/";
        $row = $this->selectOne('settings', 'id', 1);
        if (empty($row['logo'])){
            return false;
        }
        $unlinkfile = $uploaddir . $row['logo'];
        return $unlinkfile;
    }

    /**
     * method for checking if logo exists
     *
     * @return boolean  true on success or false on failure
     */
    public function logoExist(){
        $logo = $this->getLogoFile();
        return (file_exists($logo));
    }

    /**
     * method for deleting logo in db table
     * @return  boolean true on success or false on failure
     */
    function deleteLogoDb(){
        try {
            $values =
                array('logo'=> '');
            // so far only first row of settings table is populated
            $res = $this->update('settings', $values, 1);
            return $res;
        } catch (PDOException $e) {
            $this->fatalError($e->getMessage());
        }
    }
}