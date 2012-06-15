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
class image_form {

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
    
    public function getValidMimeTypes() {
        if (isset($this->options['mimetypes'])) {
            return $this->options['mimetypes'];
        }
        
        $valid_types = array ();
        $valid_types['gif'] = "image/gif";
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
            $this->errors[] = lang::translate('settings_upload_no_file_specified');
            return false;
        }
        
        $valid_types = $this->getValidMimeTypes ();//array ();
        if (!in_array($_FILES[$filename]['type'], $valid_types)) {
            $error = lang::translate('settings_upload_wrong_filetype_specified');
            $valid = array_keys($valid_types);
            $valid = implode(", ", $valid);
            $error.= $valid;
            $this->errors[] = $error; 
            return false;
        }
                      
        $uploaddir = config::getFullFilesPath() . $path;
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir);
        }
        
        $uploadfile = $uploaddir . '/' . basename($_FILES[$filename]['name']);
        $this->unlinkFile();
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
        $image = new image_form($options);
        if (!empty($_POST['submit'])){
            if (!$image->moveFile($options['filename'], $options['save_path'])){
                view_form_errors($image->errors);
                view_image_form_upload($options);
                if ($image->getLogoFile($options['save_path'])){
                    view_image_form_delete($options);
                }
            } else {
                $image->updateLogo();
                http::locationHeader( $options['redirect'] );
            }    
        } else if (!empty($_POST['delete'])){
            $image->unlinkFile();
            $image->deleteLogoDb();
            http::locationHeader( $options['redirect']);
        } else {
            view_image_form_upload($options);
            if ($image->getLogoFile($options['save_path'])){
                view_image_form_delete($options);
            }
        }
    }
}


/**
 * Main view file for settings/logo
 *
 * @package     settings
 */

/**
 * function for viewing logo form
 */
function view_image_form_upload ($options ){ 
    $vars = array (
        'legend_title' => $options['page_title'],
        'label_file' => lang::translate('Logo file'),
        'filename' => $options['filename'],
    );
    echo view::get('settings', 'logo_upload', $vars);

}

/**
 * function for viewing delete logo
 */
function view_image_form_delete ($options){ 
    $vars = array (
        'legend_title' => lang::translate('Delete Logo'),
        'submit' => lang::translate('Delete Current Logo'),
        'filename' => $options['filename'],
    );
    echo view::get('settings', 'logo_delete', $vars);
}
