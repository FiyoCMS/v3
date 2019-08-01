<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$view = app_param('view');
$type = app_param('type');
$cat  = app_param('cat');
$api  = app_param('api');

if(!$api)
switch($view)
{
	default :
		require("view/default.php");
	break;
	case 'bangunan' :
		require("view/bangunan.php");
	break;
	case 'rob' :
		require("view/rob.php");
	break;
	case 'multi' :
		require("view/multi.php");
	break;
	case 'tanahlongsor' :
		require("view/tanahlongsor.php");
	break;
	case 'kekeringan' :
		require("view/kekeringan.php");
	break;
	case 'login' :
        require("view/login.php");
	break;
	
}

if($api)
switch($api)
{
	case 'geojson' :
		require("api/geojson.php");
	break;	
	case 'bangunan' :
		require("api/bangunan.php");
	break;
	case 'bencana' :
		require("api/bencana.php");
	break;	
	case 'json' :
		require("api/json.php");
	break;	
}
