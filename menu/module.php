<?php

/**
 * model file for settings/menu
 *
 * @package     settings
 *
 */

 /**
  * class for manipulating  main menu order
  *
  * @package    settings
  */
class settings_menu extends db {

    /**
     *
     * @var array for holdings errors
     */
    public $errors = array();

    


  
    /**
     * method for getting list with all main menu item
     *
     * @return  array  $menus assoc array of menus to list when setting
     *                 order of menus.
     *                 Note: menu items with 'no visible url' will also be
     *                       included
     */
    function getMenuList(){
        $enabled = $this->selectQuery("select * from `menus` where parent = '0' OR parent IS NULL ORDER BY `weight`");
        return $enabled;
    }

    /**
     * method for validating order of menus
     * validates order of menus. Only unique values allowed
     */
    function validateOrder(){
        if(isset($_POST['submit'])){
            $uniq = array_unique($_POST['order']);
            $c_uniq = count($uniq);
            $post = count($_POST['order']);
            if ($post != $c_uniq){
                $this->error = lang::translate('Only unique values allowed for every menu item');
            }
        }
    }

    public function deleteMenuItem(){
        
    }

    /**
     * method for updating main menu
     *
     * @todo    return something usefull
     */
    function updateMenuList(){
        $menus = $this->getMenuList();
        $order = $_POST['order'];
        
        self::$dbh->beginTransaction();
        foreach ($order as $key => $val){
            $sql = "UPDATE `menus` SET `weight`= '$val' WHERE `title` = '$key'";
            $stmt = $this->rawQuery($sql);
            $stmt->execute();
        }

        self::$dbh->commit();
    }

    /**
     * method for updating main menu
     *
     * @todo    return something usefull
     */
    function updateMenuTitles (){
        //$menus = $this->getMenuList();
        //$order = $_POST['order'];

        self::$dbh->beginTransaction();
        foreach ($_POST as $key => $val){
            $sql = "UPDATE `menus` SET `title`= '$val' WHERE `id` = '$key'";
            $stmt = $this->rawQuery($sql);
            $stmt->execute();
        }

        self::$dbh->commit();
    }
}
