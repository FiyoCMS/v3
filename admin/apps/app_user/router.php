<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/
defined('_FINDEX_') or die('Access Denied');

$app = [
	'name'		=> 'Kemajuan Pekerjaan',
	'table'		=> $_REQUEST['app'],
	'folder'	=> 'app_'.$_REQUEST['app'],
];

$view 	= Input::get('view');
$act	= Input::get('act');
$api	= Input::get('api');

if(!$api)
switch($view)
{	
	default :
		if(!empty($view)) redirect("?app=$app[root]");	
		switch($act) {	
			default :
				require('view/default.php');
			break;
			case 'add':	 
				require('view/add.php');
			break;
			case 'edit':
				require('view/edit.php');
			break;
			case 'view':
				require('view/view.php');
			break;			
		}
	break;
	case 'group': 		 
		switch($act) {	
			default :	 
			require('view/group/view_group.php');
			break;
			case 'edit':	 
			require('view/group/edit_group.php');
			break;
			case 'add':	 
			require('view/group/add_group.php');
			break;	
		}	
	break;	
} 

if($api)
switch($api) {
	case 'datalist':	 
		require('api/user.list.php');
	break;
	case 'checkuser':	 
		require('api/user.check.php');
	break;	
	case 'status':	 
		require('api/user.status.php');
	break;	
}	
