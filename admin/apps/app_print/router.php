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
$api 	= Input::get('api');
$print	= Input::get('print');

if(!$api AND !$print)
switch($view)
{	
	default :
	 switch($act) {	
		default :
		 require_once('view/default.php');
		break;
		case 'add':	 
		 require('view/add.php');
		break;
		case 'edit':
		 require('view/edit.php');
		break;
		case 'view':
		 require('view/default.php');
		break;			
	}
	break;
	case 'category': 		 
	 switch($act) {	
		default :	 
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
	case 'kop': 		 
	 switch($act) {	
		default :	 
		 require('view/kop/default.php');
		break;
		case 'edit':	 
		 require('view/kop/edit.php');
		break;
		case 'add':	 
		 require('view/kop/add.php');
		break;	
	}	
	break;	
}

if(!$print AND $api) {		
	switch($api) {	
	   case 'page-list':	 
		   require('api/page_list.php');
	   break;
	   case 'kop-list':	 
		   require('api/kop_list.php');
	   break;
   }	
}


if($print AND !$api) {		
	switch($print) {	
	   case 'preview':	 
		   require('print/preview.php');
	   break;
	   case 'true':	 
		   require('print/cetak.php');
	   break;
   }	
}

