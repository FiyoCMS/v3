<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$app = [
	'name'		=> 'Executive Summary',
	'table'		=> $_REQUEST['app'],
	'folder'	=> $_REQUEST['app'],
];

$view 	= Input::get('view');
$act 	= Input::get('act');

switch($view) {	
	default :
	  switch($act) {
		default :
			require('view/default/view_menu.php');
		break;
		case 'add':	 
			require('view/default/add_menu.php');
		break;
		case 'edit':
			require('view/default/edit_menu.php');
		break;
	  }
	break;
	case 'category':
	  switch($act) {	 
		default:	 
			require('view/category/view_category.php');
		break;
		case 'edit':	 
			require('view/category/edit_category.php');
		break;
		case 'add':	 
			require('view/category/add_category.php');
		break;	
	  }
	break;
}