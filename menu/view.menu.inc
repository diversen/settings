<?php

/**
 * view functions for settings/menu
 *
 * @package settings
 */

/**
 * function for viewing form with menu elements to be sorted
 *
 * @param   array     menus
 * @return  void
 */
include_once "form.php";
function view_order_list($menus){
    if (empty($menus)){
        return;
    }

    if (isset($_POST['submit'])){
       
    }

?>
<div id="form_main">
<form method="post" action="">
<fieldset>
<legend><?php echo lang::translate('Determine order of menus')?></legend>
<table>
<?php
    foreach ($menus as $key => $value){ ?>
        <tr>
        <?php
        if (empty($value['url'])){ ?>
            <td><input type="hidden" name="order[<?php echo $value['title']?>]" value="<?php echo $value['weight']?>"></td>
        <?php } else { ?>
            <td><?php echo $value['title']?></td>
            <td><input type="text" name="order[<?php echo $value['title']?>]" value="<?php echo $value['weight']?>" size="2" maxlength = "2"></td>
        </tr><?php
        }
    } ?>
<tr><td><input type="submit" name="submit" value="<?php echo lang::translate('Submit')?>"></td></tr>
</table>
</fieldset>
</form>
</div><?php

}

/**
 * function to enable menu entries
 *
 * @param   array menus
 * @return  void
 */
function view_enable_list($menus){
    if (empty($menus)){
        return;
    }?>

<div id="form_main">
<form method="post" action="">
<fieldset>
<legend><?php echo lang::translate('Unenabled Menus. Check to enable')?></legend>
<table>
<?php
    foreach ($menus as $key => $value){ ?>
        <tr>
        <td><?php echo $value?></td><td><input type="checkbox" name="enable[<?php echo $value?>]" value="1"></td>
        </tr><?php
    } ?>
<tr><td><input type="submit" name="submit" value="<?php echo lang::translate('Submit')?>"></td></tr>
</table>
</fieldset>
</form>
</div><?php

}

/**
 * function for disabling menus (unused for now
 *
 * @param   array     menus
 * @return  void
 */
function view_disable_list($menus){
    if (empty($menus)){
        return;
    }?>
    
<div id="form_main">
<form method="post" action="">
<fieldset>
<legend><?php echo lang::translate('Enabled Menus. Check to disable')?></legend>
<table>
<?php
    foreach ($menus as $key => $value){ ?>
        <tr>
        <td><?php echo $value?></td><td><input type="checkbox" name="disable[<?php echo $value?>]" value="1"></td>
        </tr><?php
    } ?>
<tr><td><input type="submit" name="submit" value="<?php echo lang::translate('Submit')?>"></td></tr>
</table>
</fieldset>
</form>
</div><?php

}

/**
 * function for viewing core menu items (unused for now)
 * @param array menu items
 */
function view_core ($menus){ ?>
<h4><?php echo lang::translate('Core menus')?></h4>
<p><?php
    foreach ($menus as $key => $val) { ?>
        <?php echo lang::translate($val)?>&nbsp;<?php
    } ?>
</p><?php

}

function settings_view_titles (){

    $menu = new menus();
    $menus = $menu->getMenuList();

    view_form_start(lang::translate('settings_menu_set_main_titles'));
    $str = "<form method = \"post\" action = \"\">\n";
    $str.= "<table>\n";
    foreach ($menus as $key => $val){
        //$str.="<input type =\"text\" name=\"$val[title]\" value =\"$val[title]\" /><br />";
        $str.="<tr><td>\n";
        $str.= HTML_Form::returnText($val['id'], $val['title']);
        $str.="</td></tr>\n";
    }
    $str.= "<tr><td>" . HTML_Form::returnSubmit(lang::translate('Update')) . "</td></tr>\n";
    $str.="</table>\n";
    $str.="</form>\n";
    print $str;
    view_form_end();
}