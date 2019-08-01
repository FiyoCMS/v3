<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect(); 
$qr = null;
?>
<form method="post" action="">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_User; ?></div>
			<div class="app_link">
				<a class="btn btn-default" href="?app=user" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> <?php echo Back; ?></a>
				<button type="submit" class="btn btn-success" title="<?php echo Delete; ?>" value="Next" name="save"><i class="icon-check"></i> <?php echo Save; ?></button>
				<?php printAlert(); ?>
			</div>
		</div>			 
	</div>
<?php require('form.php'); ?>
</form>
