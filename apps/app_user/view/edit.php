<?php
/**
* @name			User
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');


?>
<input type="hidden" id="url" value="<?php echo FUrl; ?>" />
<form method="post" action="">	
	<h1><?php echo Edit_Profile; ?></h1>
	<?php echo userNotice; ?>	
	<table class="table table-nostyle">
		<tr>
			<td>Username</td>	
			<td>
				<input type="text" disabled autocomplete="off" name="user" placeholder="Username" value="<?php echo $_SESSION['USER']; ?>"/>
				min.3 character
			</td>
		</tr>
		<tr>
			<td>
				<?php echo New_Password; ?></td>	
			<td><input type="password" autocomplete="off"  name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/> min.4 character
			</td>
		</tr>
		<tr>
			<td>
			<span><?php echo Confirm_Password; ?></td>	
			<td><input type="password" name="kpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/>
		</div>
		</td>
		</tr>
		<tr>
			<td>
				<?php echo Name; ?></td>	
			<td><input type="text" name="name" placeholder="<?php echo Name; ?>" value="<?php echo $_SESSION['USER_NAME']; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				Email</td>	
			<td><input type="text" name="email" placeholder="Email"  value="<?php echo $_SESSION['USER_EMAIL']; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				Bio</td>	
			<td><textarea name="bio"rows="7"><?php echo userInfo('about',$_SESSION['USER_ID']); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<a href="<?php echo make_permalink('?app=user') ?>" class="btn btn-default"> <i class="icon-arrow-left"></i> </a></td>	
			<td>
			
			<button type="submit" name="edit" value="<?php echo Save; ?>" class="btn btn-success"><?php echo Save; ?></button>
			
			
			<a href="<?php echo make_permalink('?app=user&view=logout'); ?>" class="btn btn-default right"><?php echo Logout; ?> <i class="fa fa-signout"></i> </a>
			
			</td>
		</tr>
		
	</table>
</form>
	