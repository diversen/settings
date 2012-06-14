<div id="settings_logo_form">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="#" method="post">
<fieldset>
<legend><?=$vars['legend']?></legend>
<label for="logo"><?=$vars['label_logo_file']?></label><br />
<input type="file" name="<?=$vars['filename']?>" value="" /><br />
<label for="submit"></label><br />
<input type="submit" name="submit" value="<?php echo lang::translate('Update')?>"><br />
</fieldset>
</form>
</div>