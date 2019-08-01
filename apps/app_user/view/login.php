<?php
/**
* @name			Fi User
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('member_registration'))
	$new = "<a class='register' href='".make_permalink('?app=user&view=register')."'>". Register."</a>";
?>
<div id="user">
<h1>User Login</h1>
	<form action="" method="POST">
	<?php echo userNotice; ?>
	<table class="table table-nostyle">
		<tr>
			<td>
				Username
			</td> 
			<td>
				<input type="text" autocomplete="off" name="user" placeholder="e.g. User"/>
			</td>
		</tr>
		<tr>
			<td>
			Password
			</td> 
			<td>
			<input type="password" name="pass" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/>
			</td>
		</tr>
		
		<tr>
			<td>
			
			</td> 
			<td>
			<button type="submit" name="login" value="Login" class="btn-default btn login"> Login </button> 
			</td>
		</tr>
		<tr>
			<td>
			
			</td> 
			<td> <a href="<?php echo make_permalink('?app=user&view=lost_password') ?>"> <?php echo Lost_Password; ?>?</a> 
			&nbsp; <?php echo @$new; ?> 
			</td>
		</tr>
</table>
	</form>
</div>