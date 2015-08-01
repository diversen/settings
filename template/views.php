<?php

use diversen\lang;
use diversen\html;
/**
 * view file for settings/template
 *
 * @package settings
 */

 /**
  * function for viewing update form
  * @param  array  values  for usage in select drop down
  */
function settings_template ($values = NULL){

    if (!empty($_POST['submit'])){
        $values['template'] = $_POST['template'];
    } ?>

<div id="form_main">
<form method="post" action="">
<fieldset>
<legend><?php echo lang::translate('Edit Template')?></legend>
<p><label for="template"><?php echo lang::translate('Select template')?>:</label>
<?php echo html::selectClean('template', settings_template::getTemplates(), 'title', 'id', $values['template'])?></p>
<input type="submit" name="submit" value="<?php echo lang::translate('Update')?>"><br />
</fieldset>
</form>
</div>
<?php

}

 /**
  * function for viewing update form
  * @param  array  values  for usage in select drop down
  */
function settings_update_css ($values = NULL){

    if (isset($_POST['css'])){
        $values['css'] = $_POST['css'];
    } ?>

<div id="form_main">
<form method="post" action="/settings/template/css">
<fieldset>
<legend><?php echo lang::translate('Edit Stylesheet')?></legend>
<p><label for="css"><?php echo lang::translate('Select Stylesheet')?>:</label>
<?php echo html::selectClean('css', settings_template::getAllCss(), 'title', 'id', $values['css'])?></p>
<input type="submit" name="submit" value="<?php echo lang::translate('Update')?>"><br />
</fieldset>
</form>
</div>
<?php

}