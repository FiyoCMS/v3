<?php
/**
* @name			Fi User
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('member_registration'))
	$new = "<a class='register' href='".make_permalink('?app=user&view=register')."'>". Register ."</a>";
?>
<div id="user">
<h1><?php echo Lost_Password; ?></h1>
	<form action="" method="post">
	<?php echo userNotice; ?>
	<table class="table table-nostyle">
		<tr>
			<td colspan="2">
				<?php echo user_Password_Reminder; ?>
			</td>
			<td>
				
			</td>
		</tr>
		<tr>
			<td>
				Email
			</td>
			<td>
				<input type="text" name="email" />
			</td>
		</tr>
		<tr>
			<td>
				
			</td>
			<td>
				<button type="submit" name="forgot" value="<?php echo Send; ?>" class="btn-default btn login"><?php echo Send; ?></button>
			</td>
		</tr>
		<tr>
			<td>
				
			</td>
			<td>
				<a href="<?php echo make_permalink('?app=user&view=login') ?>"> <?php echo Login; ?></a> &nbsp; <?php echo @$new; ?>
			</td>
		</tr>
	</table>
	</form>
</div>