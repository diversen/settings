<?php

namespace modules\settings\lib;

use diversen\conf;
use diversen\db;
use diversen\file;
use diversen\html;
use diversen\http;
use diversen\lang;
use diversen\session;
use diversen\template;
use diversen\view;
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
class module {

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
    public function updateFile ($filename = 'logo'){
        $db = new db();

        $values = array(
            $this->db_column => $_FILES[$filename]['name']);
            // so far only first row of settings table is populated
            //therefor:  id = 1
        $res = $db->update($this->db_table, $values, 1);
        return $res;
    }
    
    public function getValidMimeTypes() {
        if (isset($this->options['mimetypes'])) {
            return $this->options['mimetypes'];
        }
        
        $valid_types = array ();
        $valid_types['gif'] = "image/gif";
        $valid_types['svg'] = "image/svg+xml";
        $valid_types['jpeg'] = "image/jpeg";
        $valid_types['pjpeg'] = "image/pjpeg";
        $valid_types['png'] = "image/png";
        $valid_types['x-icon'] = 'image/x-icon';
        $valid_types['icon'] = 'image/vnd.microsoft.icon';
        return $valid_types;
    }

    /**
     * method for uploading and moving a image
     * @param string $filename the $_FILES['name']
     * @param string $path the relative path, e.g. '/logo'
     * @return int $int 1 on success and 0 on failure 
     */
    public function moveFile($filename = 'logo', $path = '/logo'){

        if(empty($_FILES[$filename]['name'])) {
            $this->errors[] = lang::translate('No file was specified');
            return false;
        }
        
        $valid_types = $this->getValidMimeTypes ();
        
        $mime = file::getMime($_FILES[$filename]['tmp_name']);
        if (!in_array($mime, $valid_types)) {
            $error = lang::translate('Wrong mime-type. These are allowed: ');
            $valid = array_keys($valid_types);
            $valid = implode(", ", $valid);
            $error.= $valid;
            $this->errors[] = $error; 
            return false;
        }
                      
        $uploaddir = conf::getFullFilesPath() . $path;
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir);
        }
        
        
        $uploadfile = $uploaddir . '/' . rawurldecode($_FILES[$filename]['name']);
        $this->unlinkFile($path);
        if (isset($_FILES[$filename])){
            if (move_uploaded_file($_FILES[$filename]['tmp_name'], $uploadfile)) {
                return true;
            } else {
                return false;
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
        $uploaddir = conf::getFullFilesPath() . $path;
        $row = $db->selectOne($this->db_table, 'id', 1);
        if (empty($row[$this->db_column])){
            return false;
        }
        $unlinkfile = $uploaddir . '/' . $row[$this->db_column];
        if ($this->getFile('/logo')){
            return unlink($unlinkfile);
        } else {
            return false;
        }
    }

    /**
     * method for getting logo file
     * @return boolean $res true on success or false on failure
     */
    public function getFile($path = '/logo'){
        $db = new db();
        $uploaddir = conf::getFullFilesPath() . $path;
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
    function deleteFileFromDb(){
        $db = new db();
        $values =
            array($this->db_column => '');
        // so far only first row of settings table is populated
        $res = $db->update($this->db_table, $values, 1);
        return $res;
    }
    
    /**
     * create a image_form controller
     * @param array $options e.g. 
     *              array (
     *                  'page_title' => lang::translate('Edit Logo'), 
     *                  'redirect' => '/settings/logo/index', 
     *                  'db_table' => 'settings',
     *                  'db_column' => 'logo',
     *                  'filename' => 'logo',
     *                  'save_path' => '/logo',
     *              );
     */
    public static function imageFormController ($options) {
        template::setTitle($options['page_title']);
        $image = new self($options);
        if (!empty($_POST['submit'])){
            if (!$image->moveFile($options['filename'], $options['save_path'])){
                html::errors($image->errors);
                self::formUpload($options);
                if ($image->getFile($options['save_path'])){
                    self::formDelete($options);
                }
            } else {
                $image->updateFile($options['filename']);
                session::setActionMessage(lang::translate('Image updated'));   
                http::locationHeader( $options['redirect'] );
            }    
        } else if (!empty($_POST['delete'])) {
            $image->unlinkFile($options['save_path']);
            $image->deleteFileFromDb();
            session::setActionMessage(lang::translate('Image deleted'));
            http::locationHeader($options['redirect']);
        } else {
            self::formUpload($options);
            if ($image->getFile($options['save_path'])) {
                self::formDelete($options);
            }
        }
    }

    /**
     * function for viewing image form
     */
    public static function formUpload($options) {
        $vars = array(
            'legend' => $options['page_title'],
            'label' => lang::translate('Update image'),
            'filename' => $options['filename'],
            'submit' => lang::translate('Update')
        );
        echo view::get('settings', 'logo_upload', $vars);
    }

    /**
     * function for viewing delete image
     */
    public static function formDelete($options) {
        $vars = array(
            'legend' => lang::translate('Delete image'),
            'submit' => lang::translate('Delete'),
            'filename' => $options['filename'],
        );
        echo view::get('settings', 'logo_delete', $vars);
    }
}
