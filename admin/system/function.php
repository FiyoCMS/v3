<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
/****************************************/
/*			 Loader Function 			*/
/****************************************/
//memuat admin apps
function baseApps($file){		
	//load parameter untuk bagian View
	if(file_exists("apps/$file/parameter.php")) {
		include("apps/$file/parameter.php");	
	}			
	if(file_exists("apps/$file/router.php"))
		require ("apps/$file/router.php");
	else if(file_exists("apps/$file/$file.php"))
		require ("apps/$file/$file.php");
	else
		htmlRedirect('index.php');
}

//memuat admin system apps
function baseSystem($file){
    //if(!Input::get('print') AND Input::get('view') !== 'print' AND Input::get('view') !== 'api') {
        $con = "apps/app_$file/controller.php";	
		if(file_exists($con))  {			
			
			//load parameter untuk bagian Controller
			if(file_exists("apps/app_$file/parameter.php")) {
				include("apps/app_$file/parameter.php");	
			}			
			require_once($con);
		}			
		else  {
        	$con = "apps/app_$file/sys_$file.php";	
        	if(file_exists($con)) require_once($con);	
		}
    //}
}

//memuat fungsi admin apps
function loadSystemApps(){
	include('system/apps.php');		
	if(!empty($_SESSION['USER_ID']) AND  userInfo())
	sysAdminApps();
}

/****************************************/
/*			 Check User Login			*/
/****************************************/
//cek status user dalam keadaan login melalui tabel session_login
function check_backend_login() {
	if(!empty($_SESSION['USER_ID']) AND  userInfo()){
		load_themes();
	}
	else {
		$_SESSION['USER']		= null ;
		$_SESSION['USER_ID']	= null ;		
		$_SESSION['USER_LOG']	= null ;
		$_SESSION['USER_NAME']	= null ;
		$_SESSION['USER_EMAIL'] = null ;
		$_SESSION['USER_LEVEL'] = null ;

		if(Input::get('view') != 'api'  AND !Input::get('api'))		
			load_login();
		else if (Input::get('api')  AND !Input::get('app')) {
			header('Content-Type: application/json');	
			$api 	= Input::get('api');
			$path 	= "../api/" . $api .".php";
			if(file_exists($path)) {
				include_once($path);
			}
		}
		else {
			header('Content-Type: application/json');			
			die(json_encode(
				[
					'status' => 'error', 
					'code' => '201', 
					'text' => 'Access Denied'
				]));
		}
	}
}

//memanggil template sesuai fungsi select_themes()
function load_themes(){	
	if(Input::post('fiyo_logout')){
		User::logout();	
		redirect(getUrl());
	}	
	else {		
		select_themes('index');	
	}
}

//memanggil file login jika user belum login
function load_login() {
	if(isset($_POST['fiyo_login']))	{
		$db = new FQuery();
		$user = addslashes(Input::post('user'));
		$pass =  MD5(Input::post('pass'));
		$login = User::login($user, $pass);
		
		if($login AND  userInfo())	
			redirect(getUrl());
		else {
			select_themes('login');
			alert('error',Login_Error,true);	
		}
	}
	else {
		if(isset($_GET['theme']))
			die('Redirecting...');
		else
			select_themes('login');
	}
}

//memilih tema AdminPanel sesuai dengan nilai admin_theme pada tabel setting
function select_themes($log, $stat = NULL){					
	$themePath = siteConfig('admin_theme');
	if(isset($_SESSION['PLATFORM']) OR isset($_GET['platform'])) {	
		if(isset($_GET['platform'])) {
			$_SESSION['PLATFORM'] = $_GET['platform'];
			if($_GET['platform'] == 'desktop')
				$_SESSION['ROOT_PLATFORM'] = 'assets';		
			if($_GET['platform'] == 'android')
				$_SESSION['ROOT_PLATFORM'] = 'file:///android_asset/www';
		}		
		define("AdminPath",$_SESSION['ROOT_PLATFORM']);
	}
	else  {
		define("AdminPath","themes/$themePath");
	}
	define('ThemePath',"themes/$themePath");


	if($log == "login") {
		$file =  "themes/$themePath/login.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load AdminTheme";
		forgot_password();
	}
	else if($log=="index") {		
		$minLevel = 3;
		if(!empty(siteConfig('special_level')))
			$minLevel = siteConfig('special_level');

		if(USER_LEVEL > $minLevel) 
			htmlRedirect(FUrl);
		$file =   "themes/$themePath/index.php";
		if((Input::get('theme') =='blank' OR Input::get('act') =='print' OR Input::get('view') == 'print' OR Input::get('print')   OR Input::get('view') == 'api'  OR Input::get('api'))) {
			if(!isset($_SERVER['HTTP_REFERER']) AND Input::get('theme') =='blank') {
				redirect(str_replace(['&theme=blank', '?theme=blank'] ,"", getUrl()));
			} 
            if(!Input::get('app') AND Input::get('api')) {       
				header('Content-Type: application/json');	
				$api 	= Input::get('api');
				$path 	= "../api/" . $api .".php";
				if(file_exists($path)) {
					include_once($path);
				}
			}
			else {
				loadAdminApps();
			}
            if(!Input::get('print') AND Input::get('view') !== 'print' AND  Input::get('view') !== 'api'  AND !Input::get('api')) {                
                $end_time = microtime(TRUE);
                $n = substr($end_time - _START_TIME_,0,6);
                echo "<input type='hidden' value='$n' class='load-time'>";
            }
		}
		else if(file_exists($file)) {
			require_once($file);
		}
		else {
			echo "Failed to load AdminTheme";
		}
	}
	else {		
		redirect(FUrl);		
	}
}

function loadTheme() {
	//melakukan pengecekan login AdminPanel
	check_backend_login();

	//load to output
	$output = ob_get_contents();
	ob_end_clean();

	if(Input::server('https') == 'on') 
		$output = str_replace("http://", "https://", $output);

	if(!Input::get('print') AND Input::get('view') !== 'print' AND  Input::get('view') !== 'api'  AND !Input::get('api')) {
		ob_start(); 
			loadAppsCss();
			if(function_exists('loadModuleCss')) loadModuleCss();
			$cssasset = ob_get_contents();
		ob_end_clean();
						
		$html = str_get_html($output);
		$jsMain = "";
		foreach($html->find('script') as $e) {
			$jsMain .= $e->outertext ;
			$e->src= null;
		}

		//$jsMain = minimizeJavascriptSimple($jsMain);
		$output = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $output);

		ob_start(); 
			loadAppsJs();	
			$jsasset = ob_get_contents();
			$jsasset = preg_replace("/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\)\/\/.*))/", "", $jsasset);
		ob_end_clean();
		
		$tlx = strpos($output,"<link");
		$ntx = substr($output , 0, $tlx );
		$output = str_replace($ntx, $ntx.$cssasset,$output);
			

		
		ob_start();
			$output = str_replace(array("{sitetitle}","{siteTitle}"),siteConfig('site_title'),$output);
			$output = str_replace(array("{siteHome}","{siteUrl}","{homeurl}"),FUrl,$output);
			$output = str_replace(array("{sitename}","{siteName}"),siteConfig('site_name'),$output);
			$output = str_replace("{lang}",SiteLang,$output);

			if(checkMobile()) $m = "m-"; else $m = "";
			$output = str_replace("{m-}",$m,$output);
			$output = str_replace(array("{pid}","{PID}"),Page_ID,$output);	

			if(USER_ID) {
				$output = str_replace(["{userID}","{userid}"],USER_ID,$output);
				$output = str_replace(["{userName}","{username}"],USER_NAME,$output);
				$output = str_replace(["{userLevel}","{userlevel}"],USER_LEVEL,$output);	
				$output = str_replace(["{userEmail}","{useremail}"],USER_LEVEL,$output);		
			} else {		
				$output = str_replace("{userid}",'',$output);
				$output = str_replace("{username}",'',$output);
				$output = str_replace("{userlevel}",'',$output);	
			}
		
		
		$tlb = strpos($output,"</body>");
		$ntb = substr($output ,$tlb );
		$output = str_replace($ntb, $jsMain. $jsasset.$ntb,$output);	
		ob_end_clean();
	}

	ob_start();
	$output = preg_replace('#^\s*//.+$#m', "", $output);
	$output = preg_replace('!/\*.*?\*/!s', '', $output);
	$output = preg_replace('/\n\s*\n/', "\n", $output);
	$output = preg_replace('/<!--(.*)-->/Uis', "", $output);
	$output = preg_replace(array('(( )+\))','(\)( )+)'), ')', $output);
	$output = str_replace(array("\t","\n"), ' ', $output);
	$output = str_replace(array("  ","   "), ' ', $output);
	$output = str_replace("  ", ' ', $output);

	
	preg_match_all('/\{{(.*?)\}}/',$output,$position); 
	if(!empty($position[1])) {
		$no = 1;
		foreach($position[1] as $val) {
			$output = str_replace(["{{","}}"],  "" ,$output);
			// $ini  = "zzz";
			// if(isset($val))			
			// eval("\$p = \"$val\";");
			// $output = str_replace($val,  $p ,$output);
			// $no++;
		}
	}	

	/* timer */
	$et = microtime(TRUE) - _START_TIME_;
	$et = substr($et,0,6)."s";

	$output = str_replace(array("{loadtime}","{loadTime}"),$et,$output);
	/* timer */

	if(Input::server('https') == 'on') $output = str_replace("http://", "https://", $output);
	echo $output;
	ob_end_flush();

}

function minimizeJavascriptSimple($javascript){
	return preg_replace(array("/\s+\n/","/\n\s+/","/ +/"),array("\n","\n "," "),$javascript);
	}

function loadAppsCss() {	
	$apps = app_param('app');
	$file = "apps/app_$apps/assets/css.php";	
	if(file_exists($file)) {
		require_once ($file);
	}
}

function loadAppsJs() {	
	$apps = app_param('app');
	$file = "apps/app_$apps/assets/js.php";	
	if(file_exists($file)) {
		require_once ($file);
	}
}

function redirect_www() {
	if($_SERVER['SERVER_ADDR'] != '127.0.0.1' AND $_SERVER['SERVER_ADDR'] != '::1' AND $_SERVER['SERVER_ADDR'] != $_SERVER['HTTP_HOST'] ) {
		if(siteConfig('sef_www')) {
			if(!strpos(getUrl(),"//www.")) {
				$link = getUrl();
				if(Input::server('https') !== 'off')  $http = "https"; else $http = "http";
				$link = str_replace("$http://","$http://www.",$link);
				redirect($link);
			}
		}
		else {
			if(strpos(getUrl(),"//www.")) {
				$link = getUrl();
				if(Input::server('https') !== 'off')  $http = "https"; else $http = "http";
				$link = str_replace("$http://www.","$http://",$link);
				redirect($link);
			}
		}
	}
}

//fungsi lupa password
function forgot_password(){
	if(isset($_POST['forgot_password'])) {
		$db = new FQuery();  
		$sql = $db->select(FDBPrefix."user","*","status=1 AND email='$_POST[email]'");
		$qr= mysql_affected_rows();
		$qrs = mysql_fetch_array($sql);
		if($qr<1){				
			alert('error',Remember_Error);
		}
		else {		
			$reminder = randomString(32);
			$_SESSION['USER_REMINDER'] = $reminder;
			$_SESSION['USER_REMINDER_ID'] = $qrs['id'];
			$reminder = "app=user&res=$reminder";
			$to  = "$_POST[email]" ;
			$webmail = siteConfig('site_mail'); 
			$domain  = str_replace("/","",FUrl()); 
			if(empty($webmail)) $webmail = "no-reply@$domain";
			if(siteConfig('lang') == 'id') {
			$subject = 'Konfirmasi Reset Password';
			$message = "<font color='#333'>
			<p>Halo, $qrs[name]</p> 
			<p>Anda telah meminta kami untuk mengirimkan password baru.</p>
			<p>Konfirmasi pesan ini dengan klik link konfirmasi berikut.</p>
			<p>&nbsp;</p>
			<p><a href='".FUrl."?$reminder'>".FUrl."?$reminder</a></p>
			<p>&nbsp;</p>
			<p>Pesan ini akan valid dalam 1-2 hari hingga Anda melakukan konfirmasi untuk reset password.</p>
			<p>Jika Anda ingin membatalkan proses ini, abaikan saja email ini hingga kode kadaluarsa dalam 1-2 hari.</p>
			<p>Terimakasih.</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";
			}
			else {
			$subject = 'Password Reset Confirmation';
			$message = "<font color='#333'>
			<p>Hello, $qrs[name]</p> 
			<p>You have asked us to send you a new password.</p>
			<p>Confirm this message by click the following link.</p>
			<p>&nbsp;</p>
			<p><a href='".FUrl."?$reminder'>".FUrl."?$reminder</a></p>
			<p>&nbsp;</p>
			<p>This message will be valid within 1-2 days so you do confirm to reset the password.</p>
			<p>If you want to cancel this process, ignore this letter to Expired code in 1-2 days.</p>
			<p>Thankyou.</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";			
			}
		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
			$headers .= "To: $qrs[name] <$_POST[email]>" . "\r\n";
			
			$headers .= "From: ".SiteTitle. "<$webmail>" ."\r\n";
			$headers .= "cc :" . "\r\n";
			$headers .= "Bcc :" . "\r\n";

		// Mail it
			$mail = @mail($to,$subject,$message,$headers);
			if($mail)  {
				alert('info',Password_sent_to_mail);
				htmlRedirect("index.php",3);	
			}
			else
				alert('error',Failed_send_mail);
		}
	}
}