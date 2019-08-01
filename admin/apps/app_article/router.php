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
		 require('view/add_article.php');
		break;
		case 'edit':
		 require('view/edit_article.php');
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
	case 'tag': 		 
	 switch($act) {	
		default :	 
		 require('view/tag/view_tag.php');
		break;
		case 'edit':	 
		 require('view/tag/edit_tag.php');
		break;
		case 'add':	 
		 require('view/tag/add_tag.php');
		break;	
	}	
	break;	
	case 'comment': 		 
	 switch($act) {	
		default :	 
		 require('view/comment/view_comment.php');
		break;
		case 'edit':	 
		 require('view/comment/edit_comment.php');
		break;
		case 'add':	 
		 require('view/comment/add_comment.php');
		break;	
	}	
	break;	
}

if(!$print AND $api) {		
	 switch($api) {	
		case 'article-list':	 
			require('api/article_list.php');
		break;
		case 'article-status':	 
		 	require('api/article_status.php');
		break;	
		case 'article-menu':	 
		 	require('api/article_menu.php');
		break;	

		
		case 'comment-list':	 
			require('api/comment_list.php');
		break;
		case 'comment-status':	 
			require('api/comment_status.php');
		break;
	}	
}

