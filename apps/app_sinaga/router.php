<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$view = app_param('view');
$type = app_param('type');
$cat  = app_param('cat');
$std  = app_param('std');

switch($view)
{
	default :
		require("view/default.php");
	break;
	case 'login' :
        require("view/login.php");
	break;
	
}
