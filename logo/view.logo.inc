<?php

/**
 * Main view file for settings/logo
 *
 * @package     settings
 */

/**
 * function for viewing logo form
 */
function view_create (){ ?>
<div id="form_main">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="" method="POST">
<fieldset>
<legend><?php echo lang::translate('Edit Logo')?>:</legend>
<label for="logo"><?php echo lang::translate('Logo file')?>:</label><br />
<input type="file" name="logo" value="" /><br />
<label for="submit"></label><br />
<input type="submit" name="submit" value="<?php echo lang::translate('Update')?>"><br />
</fieldset>
</form>
</div>
<?php

}

/**
 * function for viewing delete logo
 */
function view_delete (){ ?>
<div id="form_main">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form method="POST" action="">
<fieldset>
<legend><?php echo lang::translate('Delete Logo')?>:</legend>
<label for="submit"></label>
<input type="submit" name="delete" value="<?php echo lang::translate('Delete Current Logo')?>">
</fieldset>
</form>
</div>
<?php

}