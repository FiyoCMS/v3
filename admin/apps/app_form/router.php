<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_REQUEST['act']))
	$act=$_REQUEST['act'];
else
	$act = null;
	
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