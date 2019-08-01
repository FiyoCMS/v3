<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$act = Input::get('act');
$api = Input::get('api');

if(!$api)
switch($act)
{	
	default :
	 require('view/view_permalink.php');
	break;
	case 'add':	 
	 require('view/add_permalink.php');
	break;
	case 'edit':
	 require('view/edit_permalink.php');
	break;
	case 'view':
	 require('view/view_permalink.php');
	break;
} 

elseif($api) 
switch($api)
{	
	default :
		die('Access Denied');
	break;
	case 'list':
	 require('api/permalink_list.php');
	break;
	case 'status':
	 require('api/status.php');
	break;
}
