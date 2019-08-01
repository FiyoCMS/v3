<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


$view = Input::get('view');
$act 	= Input::get('act');
$api 	= Input::get('api');

if(!$api)
switch($act)
{
	case 'add':	 
	 require('view/add_module.php');
	break;
	case 'edit':
	 require('view/edit_module.php');
	break;
	case 'view':
	 require('view/view_module.php');
	break;
	case 'enable':
	 require('view/view_module.php');
	break;
	default :
	 require('view/view_module.php');
	break;
}

if($api)
switch($api)
{
	case 'save':	 
	 require('api/save.php');
	break;
	case 'status':	 
	 require('api/status.php');
	break;
	case 'spot_position':	 
	 require('api/spot_position.php');
	break;
}