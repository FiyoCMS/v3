<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 1) htmlRedirect("index.php");

printAlert();
$type = null;

$view 	= Input::get('view');
$api 	= Input::get('api');
$type 	= Input::get('type');


if(!$api)
switch($view) {
	case 'apps':	 
		require('view/apps.php');
	break;
	case 'plugins':
		 require('view/plugins.php');
	break;
	case 'themes':
		 require('view/themes.php');
	break;
	case 'modules':
		 require('view/modules.php');
	break;
	case 'backup':
		 require('backup.php');
	break;
	case 'install':
		 require('installer.php');
	break;
	default :
		 require('general.php');
	break;
}


if($api)
switch($api) {
	case 'backup':
		 require('api/backuper.php');
	break;
}


?>	