<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

include('theme_data.php');
defined('_FINDEX_') or die('Access Denied');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
	<title><?php echo SiteTitle; ?> - AdminPanel</title>
	<?php include("module/auth.php"); ?>
	<link rel="shortcut icon" href="<?php echo AdminPath; ?>/images/favicon.png" />
	<link href="<?php echo AdminPath; ?>/css/font/font-awesome.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo AdminPath; ?>/css/login.css" type="text/css">
	<script type="text/javascript" src="<?php echo AdminPath; ?>/js/jquery.min.js"></script>	
	<script type="text/javascript">
	<?php if(!isset($_SESSION['USER_ID']) AND isset($_GET['theme'])) : ?>
		location.reload();
	<?php endif; ?>							
	$(function() {
		$(".name").focus();
		$(".submit").click(function(e) {				
			$(".alert").remove();
			var name = $(".name").val();
			var pass = $(".pass").val();
			var url = $(".url").val();
			var t = $(this);
			if(pass !== '' && name !== '') {
				$(this).html("Loading...");	
				$(this).attr("disabled","disabled");	
				e.preventDefault();	
				$.ajax({
					url: "?api=login",
					type: "GET",
					data: "user="+name+"&pass="+pass+"&url="+url,
					timeout : 10000,
					error: function(data){	
						console.log(data);
						$(t).html("Login");
					},	
					success: function(resp){
						try {
							if(resp.status == 'error') {
								$(t).removeAttr("disabled");			
								$(t).html("Login");		
								$(".step").prepend(resp.html);						
							} else if(resp.status == 'ok') {
								$(".step").prepend(resp.html);
								location.reload();
							} else {
								$(t).removeAttr("disabled");						
								$(t).html("Login");		
								$("#steps").prepend("Login Error!");	
							}
						} catch (e) {
							$(".step").prepend(resp);	
							$(t).removeAttr("disabled");			
							$(t).html("Login");		
						}
						
					}
				});						
			} 
			else {	
				if(name === '') {
				$(".name").focus();
				}
				else if(pass === '') {
				$(".pass").focus();
				}
				e.preventDefault();
				return false;
			}
		});
		
		$(".send-mail").click(function(e) {
			$(".notice, .alert").fadeOut('slow');
			var email = $(".email").val();
			var url = $(".url").val();
			if(email !== '' ) {
				var t = $(this).html("Loading...");	
				e.preventDefault();	
				$.ajax({
					url: "?api=lost_password",
					type: "GET",
					data: "email="+email+"&url="+url,
					timeout : 10000,
					error: function(data){
						$(t).html("Send");	
					},	
					success: function(data){
						var json = $.parseJSON(data);
							$(t).html("Send");		
							$(".step").prepend(json.alert);			
						if(json.status == '1') {	
							$(".email").val('');			
						} 
						setTimeout(function(){
							$(".notice, .alert").fadeOut('slow');
						}, 10000);	
					}
				});
			}
			else {	
				if(email === '') {
				$(".email").focus();
				}
				e.preventDefault();
				return false;
			}
		});
		
		<?php if(!isset($_POST['forgot_password'])) :  ?>
		$(".femail").hide();
		<?php else : ?>
		$(".flogin").hide();		
		<?php endif; ?>
		
		$(".lost-password").click(function(e) {			
			$(".pass").toggle();			
			$(".name").toggle();			
			$(".email").toggle();			
			$(".back").toggle();			
			$("span").toggle();			
			$("button").toggle();			
		});
		
		
		
	});	
	</script>	 
</head>
<body style="background: linear-gradient(
      rgba(40, 40, 40, 0.4), 
      rgba(0, 0, 0, 0.1)
    ) top right fixed, url(<?php echo $PARAM['background'];?>)  top right fixed; background-size: cover" ;>    
	<div id="content">
        <div id="steps">
             <form id="formElem" method="post">
                <fieldset class="step">
                    <div class="legend">
					<b style='font-size: 90%'><?php echo str_replace("-","<br>",str_replace(" - ","<br>", SiteName)); ?></div>
                    <div>
                        <input name="user"  type="text" class="name" placeholder="Username" />                    
                        <input name="email" autocomplete="OFF" type="email" class="email femail" placeholder="Email" style="display: none" />
                    </div>
                    <div>
                        <input name="pass" type="password" class="pass"  placeholder="Password" />
                    </div>
                    <div class="button">
                        <button type="submit" name="fiyo_login" class="submit flogin" style="background: <?php echo $PARAM['button_color'];?>">Login</button>
                        <button type="submit" name="forgot_password" class="send-mail femail" style="background: <?php echo $PARAM['button_color'];?> display: none">Send</button>
                    </div>
					<div style="width: 100%; text-align: center; margin-top: 10px;">
						<span class="lost-password femail" style="display: none">User Login</span>
					</div>
                </fieldset>
			</form>	
         </div>
    </div>
	<img src="<?php echo AdminPath; ?>/images/ok.png" style="display: none; "/>
</body>
</html>