<?php

/**
 * view file for sub module settings/text
 * 
 * @package settings
 */

/**
 * function for viewing an update form for text
 * @param array     db values for settings
 */
function view_update_text ($values = NULL){

    if (isset($_POST['submit'])){
        $values['footer_message'] = $_POST['footer_message'];
        $values['description'] = $_POST['description'];
    }

?>
<div id="form_main">
<form method="post" action="">
<fieldset>
<legend><?php echo lang::translate('Edit Misc Settings')?>:</legend>
<label for="footer_message"><?php echo lang::translate('Footer Message')?>:</label><br />
<textarea rows="10" cols="40" name="footer_message"><?=$values['footer_message']?></textarea><br />
<label for="description"><?php echo lang::translate('Description')?>:</label><br />
<textarea rows="10" cols="40" name="description"><?=@$values['description']?></textarea><br />
<label for="submit"></label><br />
<input type="submit" name="submit" value="<?php echo lang::translate('Update')?>">
</fieldset>
</form>
</div>

<?php

}