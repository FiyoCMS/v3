<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>

<div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
	<!-- .nav -->
	<ul class="nav navbar">
		<li class='dropdown profile'>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php 
					echo $_SESSION['USER_NAME'];
					$autmail =	md5($_SESSION['USER_EMAIL']);
					echo " <span class='gravatar' data-gravatar-hash=\"$autmail\"></span>"; 
				?>
			</a>
			<div class="popover fade bottom in" style=""><div class="arrow" style=""></div></div>
			<ul class="dropdown-menu">
				<li><a href="?app=user&act=edit&id=<?php echo USER_ID; ?>"><i class="icon-pencil"></i> Edit Profile</a></li>
				<li class="divider"></li>
				<li><form method="post" action="">
				<button type="submit" name="fiyo_logout" id="user-logout" value="Log Out" title="Click to logout"><i class="icon-sign-out"></i> Sign Out</button></form></li>
			</ul>
		</li>		
	</ul>
</div>