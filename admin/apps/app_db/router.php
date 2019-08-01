<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

//Router File
defined('_FINDEX_') or die('Access Denied');


$view 	= Input::get('view');
$act 	= Input::get('act');
$data 	= Input::get('data');
$api 	= Input::get('api');

if(!$api)
switch($act)
{	
	case 'column':	 
		 require('view/add.php');
	break;
	case 'tabel':
		require('view/edit.php');
	break;
	case 'view':
		require('view/default.php');
	break;	
	default :
		require('view/default.php');
	break;
}



switch($api)
{
	case 'column':	 
		require('view/column.php');
	break;
}
