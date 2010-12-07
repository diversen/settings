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
            <td><?php echo lang::translate($value['title'])?></td>
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
 * function for disabling menus
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
 * function for viewing core menu items
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