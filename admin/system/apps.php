<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

//get variable $app from parameter url -> app
$app = app_param('app'); 
$url = $_SERVER['PHP_SELF']; //returns the current URL
$prt = explode('/',$url);
$dir = $_SERVER['SERVER_NAME'];

for ($i = 0; $i < count($prt) - 1; $i++) {
	$dir .= $prt[$i] . "/";
}

$http 		= Input::server('REQUEST_SCHEME');
$themePath	= siteConfig('admin_theme');
define("FAdmin","$http://$dir");
define("FAdminPath","themes/$themePath");

if(!empty($app)){
	if(!file_exists("apps/app_$app/app_$app.php") AND !file_exists("apps/app_$app/router.php"))
	{
		function sysAdminApps() {
			//htmlRedirect('../'.siteConfig('backend_folder'));
			/* blank line */
		}
		function loadAdminApps() {		
			/* blank line */
		}
	}
	else {		
		/** Auth Access **/
		$view = app_param('view');
		$auth = 0;
		if(DB::tableExists(FDBPrefix.'user_auth'))
		$auth = DB::table(FDBPrefix.'user_auth')
			->where("app = '". 	app_param('app').	"'
				AND view = '". 	app_param('view').	"'
				AND act  = '". 	app_param('act').	"'
				AND cat  = '". 	app_param('cat').	"'
				AND api  = '". 	app_param('api').	"'
				AND pid = '". 	app_param('id').	"'
				AND adminpanel = '1'
				")
			->get();

		if(is_array($auth))
		if(count($auth)) {
			if(isset($auth[0])) {
				$auth = $auth[0];
				if(in_array(USER_LEVEL , explode(",", $auth['level'])) or USER_LEVEL == 1)
					$ress = true;
				else if(app_param('view') OR app_param('act') OR app_param('cat')) {
					htmlRedirect(FAdmin. "?app=$app");
				}
				else {
					htmlRedirect(FAdmin);
				}

			}
		}
		/** End off Auth Check **/

		function sysAdminApps() {	
			$app = app_param('app'); 	
			baseSystem($app);	
		}
		function loadAdminApps() {
			$app = app_param('app'); 
			baseApps("app_".$app);				
		}
	}
}
else {
	function sysAdminApps() {	
        //htmlRedirect('?app=efile&view=folder');
	}
	function loadAdminApps() {		
		$themePath = siteConfig('admin_theme');
		require("themes/$themePath/dashboard.php");			
	}
}



?>