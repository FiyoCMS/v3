<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$view = menu_param('view',menuParam);
if($view == 'login') $view1='selected';
if($view == 'register') $view2='selected';
if($view == 'profile') $view3='selected';
if($view == 'logout') $view4='selected';
if($view == 'automatic') $view5='selected';


?>
<script type="text/javascript">
$(document).ready(function(){
	var loading = $("#loading");
	loading.fadeOut();	
	var link = $("#link").val()
	if(link=="#") $("#link").val("?app=user&view=login");
	$("#type").change(function(){
		var tm = $("#type").val();	
		if(tm=='login')
			$("#link").val("?app=user&view=login");
		else if(tm=='register')
			$("#link").val("?app=user&view=register");				
		else if(tm=='profile')
			$("#link").val("?app=user&view=profile");				
		else if(tm=='logout')
			$("#link").val("?app=user&view=logout");			
		else
			$("#link").val("?app=user");	
		
	});
});
</script>

<input type="hidden" name="totalParam" value="1"/>
<input type="hidden" name="nameParam1" value="view" />	

<div class="box">								
	<header>
		<a class="accordion-toggle" data-toggle="collapse" href="#user-parameter">
			<h5>Article Parameter</h5>
		</a>
	</header>	
	<div id="user-parameter" class="collapse in">
			<table class="data2">				
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td>Page Type</td>
				<td>
					<select id="type">
						<option value='login' <?php echo @$view1;?>>Login Page</option>
						<option value='register' <?php echo @$view2;?>>Register Page</option>
						<option value='profile' <?php echo @$view3;?>>Profile Page</option>
						<option value='logout' <?php echo @$view4;?>>Logout Page</option>
						<option value='auto' <?php echo @$view5;?>>Automatic</option>
					</select>
				</td>
			</tr>			
		</table>
	</div>
</div>
