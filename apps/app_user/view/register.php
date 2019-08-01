<?php
/**
* @name			User
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/


defined('_FINDEX_') or die('Access Denied');

if(!siteConfig('member_registration')) : ?>

<h1>User Registration</h1>
<p><?php echo RegisterNotAllowed__; ?></p>

<?php else :?>

<script> 
function reloadCaptcha() {
	document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
}
</script>
<div id="user">
	<h1>User Registration</h1>	
	<form method="post" action="">	
	<input type="hidden" id="url" value="<?php echo FUrl; ?>" />


		<?php if(userNotice != 'need_admin_activation' AND userNotice != 'need_email_activation') : ?>	
		<?php echo userNotice; ?>		
		
		<table class="table table-nostyle">
		<tr>
			<td>Username</td>	
			<td>
				<input type="text" autocomplete="off" name="user" placeholder="Username" value=""/>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo New_Password; ?></td>	
			<td><input type="password" autocomplete="off"  name="password" placeholder="<?php echo New_Password; ?>"/> 
			</td>
		</tr>
		<tr>
			<td>
			<span><?php echo Confirm_Password; ?></td>	
			<td><input type="password" name="kpassword" placeholder="<?php echo Confirm_Password; ?>"/>
		</div>
		</td>
		</tr>
		<tr>
			<td>
				Email</td>	
			<td><input type="text" name="email" placeholder="Email" />
			</td>
		</tr>
		<tr>
			<td>
				Captcha</td>	
			<td><img src="<?php echo FUrl; ?>/plugins/plg_mathcaptcha/image.php" alt="Click to reload image" title="Click to reload image" id="captcha" onclick="javascript:reloadCaptcha()" /><input type="text" name="capthca" placeholder="What the result?" class="security" /></div>
		
			</td>
		</tr>
		<tr>
			<td>
			</td>	
			<td>
			
			<button type="submit" name="register" value="<?php echo Save; ?>" class="btn btn-success"><?php echo Register; ?></button>
			
			
			
			</td>
		</tr>
		<tr>
			<td></td>	
			<td>
			
				<a href="<?php echo make_permalink('?app=user') ?>"> <?php echo Login; ?> </a> &nbsp; 
				<a href="<?php echo make_permalink('?app=user') ?>"> <?php echo Lost_Password; ?>? </a>
			
			
			
			</td>
		</tr>
		
	</table>
		






		<?php elseif(userNotice != 'need_email_activation') : ?>
			<?php alert("info",user_Registration_Success, true); ?>
			<div>			
				<?php echo user_Email_Activation; ?>
				<?php loadModule('user-register'); ?>
			</div>
		<?php elseif(userNotice == 'need_admin_activation') : ?>
			<?php alert("info",user_Registration_Success, true); ?>
			<div>			
				<?php echo user_Admin_Activation; ?>
				<?php loadModule('user-register'); ?>
			</div>
		<?php endif; ?>
		
	</form>
</div> 
<?php endif ?>