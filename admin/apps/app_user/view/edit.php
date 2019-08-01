<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$qr = Database::table(FDBPrefix.'user')->
	where("id=".Input::get('id'))->
	get()[0];
	
if($_SESSION['USER_LEVEL'] >= $qr['level'] AND $_SESSION['USER_ID'] != $qr['id'] AND $_SESSION['USER_LEVEL'] != 1) {
	notice('info','Access denied! Redirecting ...',2);
	htmlRedirect('?app=user');
	}

echo Form::model($qr, ['url' => '', 'method' => 'post']);

?>

	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo Edit_User; ?></div>
			<div class="app_link">
				<a class="btn btn-default" href="?app=user" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> <?php echo Back; ?></a>
				<button type="submit" class="btn btn-success" title="<?php echo Delete; ?>" value="Next" name="edit"><i class="icon-check"></i> <?php echo Save; ?></button>	

				</button>	
				<?php printAlert(); ?>
			</div>
		</div>			 
	</div>
<?php require('form.php'); ?>	
</form>
