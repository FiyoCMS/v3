<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

/** Load core files **/ 
include_once ('config.php');
require_once ('controller.php');
include_once ('system/database.php');
include_once ('system/input.php');
include_once ('system/function.php');
include_once ('system/user.php'); 

if(siteConfig('site_status') == true OR USER_LEVEL == 1) {
	include_once ('site.php'); 
	include_once ('plugins.php'); 
	require_once ('helpers.php');
	include_once ('form.php');
	include_once ('apps.php'); 
	include_once ('modules.php');
	require_once ('html.php');
	include_once ('themes.php');
}
else {	
	define('_OFFSITE_',1); 
	include_once ('site.php'); 
	include_once ('themes-off.php');
}
