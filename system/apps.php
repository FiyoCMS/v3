<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
function loadAppsSystem() {	
	loadLang(dirname(__FILE__));
	$name = app_param('app');
	$apps = "app_$name";
	$file = "apps/app_$apps/sys_$apps.php";
		
	if(file_exists("apps/$apps/parameter.php"))
		include_once ("apps/$apps/parameter.php");

	if(file_exists("apps/$apps/controller.php"))
		require_once ("apps/$apps/controller.php");
	else	
		$file = "apps/app_$apps/sys_$apps.php";
}

function loadAppsCss() {	
	$apps = app_param('app');
	$file = "apps/app_$apps/app_style.php";	
	if(file_exists($file)) {
		require_once ($file);
	}
}

function loadAppsJs() {	
	$apps = app_param('app');
	$file = "apps/app_$apps/app_js.php";	
	if(file_exists($file)) {
		require_once ($file);
	}
}

function loadApps($echo = false) {
	ob_start();
	$qr = null; //set $qr to null value
	$view = app_param('app');
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND USER_LEVEL > 3) {	
		$view = '';
	}

	
	if(file_exists("apps/app_$view/"))
	{
		$menu = DB::table(FDBPrefix.'menu')->where("id=".Page_ID)->get(); 
		if(!count($menu)) {
			//DB::table(FDBPrefix.'permalink')->delete("pid=".Page_ID); 
		}

		if(!count($menu)) 
			$qrs = null; 
		else 			
			$qrs = $menu[0];	

			
		$theme = siteConfig('site_theme');
		//old with index
		$tfile = "themes/$theme/apps/app_$view/index.php";
		$file  ="apps/app_$view/index.php";	

		//new router
		$ntfile = "themes/$theme/apps/app_$view/router.php";
		$nfile  ="apps/app_$view/router.php";	
		
			if(!_PRINT_ AND !_API_ AND _FEED_ !== 'rss') 
				echo "<div class='apps app-$view'>";
			if(!empty($qrs['title']) AND $qrs['show_title']) 
				define("Apps_Title","$qrs[title]");	
			if($qrs['show_title'])	
				if(!defined('Apps_Title'))
				define("Apps_Title","$qrs[name]");		
			if(!_PRINT_ AND !_API_ AND _FEED_ !== 'rss') 
				echo '<div class="main_apps">';					

			if(file_exists($ntfile))
				include($ntfile);
			else if(file_exists($nfile))
				include($nfile);	
			else if(file_exists($tfile))
				include($tfile);
			else if(file_exists($file))
				include($file);		

			if(!_PRINT_ AND !_API_ AND _FEED_ !== 'rss') 
				echo' </div></div>';
	}
	else {
		if(Input::get('theme') == 'module' AND USER_LEVEL < 3) {
			echo "<div style='border: 2px solid #e3e3e3; background: rgba(250,250,250,0.8);	color :#aaa; padding: 30px; text-align: center; margin: 5px 3px; font-weight: bold;'>Main Content</div>";
		} 
		else if (Input::get('api')  AND !Input::get('app')) {
			if(Input::get('type') == 'xml') {
				header('Content-Type: application/xml');
			}
			elseif(Input::get('type') == 'html') {

			}				
			else
				header('Content-Type: application/json');	
				
			$api 	= Input::get('api');
			$path 	= "api/" . $api .".php";
			if(file_exists($path)) {
				include_once($path);
			}
		}
		else {
			echo "<h1>404 Not Found!</h1>";
		}
	}


	$apps = ob_get_contents();
	ob_end_clean();	
	
	static $flag ;
	if ( $flag === null ) {
		$flag = true;
		if($echo == true)
			return $apps;
		else
			echo $apps;
	}
}

//load Apps System
loadAppsSystem();