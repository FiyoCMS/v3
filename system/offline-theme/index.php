<?php
/**
* @version		Beta 1.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2011 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
**/

$OffTheme = FUrl.'/system/offline-theme';;

if(Input::post('login')) {	
	$user = addslashes(Input::post('user'));
	$pass = Input::post('pass');

	$login = User::login($user, $pass);


	if(User::$logged_id){
		refresh();
	}
	else  {
		refresh();
		$failed = "Username or password is incorrect!";

	}
}
?>

<html>

<head>
	<title>Pengumuman Kelulusan SMA Negeri 1 Tahunan</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="<?php echo $OffTheme; ?>/css/login.css" type="text/css">
	<script type="text/javascript" src="<?php echo $OffTheme; ?>/js/jquery.min.js"></script>
	<script type="text/javascript">
	$(function() {	
		$(".submit").click(function(e) {	
			var name = $(".name").val();
			var pass = $(".pass").val();
			if(pass !== '' && name !== '') {
				$(this).html("Loading...");	
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
		
		$(".notice").click(function() {	
			$(this).fadeOut();
		});
		setTimeout(function(){
			$('.notice').fadeOut(2000, function() {
			});				
		}, 3000);	
	});	
	</script>		
</head>

<body>        
	<div id="content">

	 <div id="steps" class="first">
            <img src="<?php echo $OffTheme; ?>/images/logo3.png" width="425">
               <p>
			   		Pengumuman Kelulusan SMA Negeri 1 Tahunan tahun pelajaran 2016/2017.
			   </p><p></p>
                    
               <p>
			   		1. Pengumuman bersifat pribadi, siswa diwajibkan untuk login terlebih dahulu menggunakan nomor peserta UN dan password menggunakan NIS.
			   </p><p></p>
               <p>
			   		2. Hasil kelulusan wajib dicetak pada tombol yang tersedia kemudian dikumpulkan ke Kurikulum untuk mendapatkan Surat Keterangan Kelulusan dari Sekolah.
			   </p>
                 
                   
               <p></p>
               <p>
			   		3. Hal-hal yang kurang jelas dapat ditanyakan kepada Tim Kurikulum.
			   </p>
                    
         </div>

		 
        <div id="steps">
	<?php if(isset($failed )) : ?>
		<div class="notice error"><?php echo $failed; ?></div>
	<?php endif; ?>
             <form id="formElem" method="post">
                <fieldset class="step">
					<div class="legend">
                    	<p class="legend s ">PENGUMUMAN KELULUSAN</p>
                    	<p  class="legend"><small>Pengumuman Kelulusan Tahun Ajar 2016/2017</small></p>
					</div>
					<div class="formin">
                    <p><input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
                       <input name="user" autocomplete="OFF" type="text" class="name" placeholder="NISN" />
                   	</p>
                    <p><input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
                        <input name="pass" autocomplete="OFF" type="password" class="pass" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" /> 						
					</p>
                    <p class="button">
                        <button type="submit" name="login" class="submit" value="true">Login</button>
                    </p>
					</div>
                      </fieldset>
				</form>	
                    
         </div>
    </div>
</body>
</html>
      