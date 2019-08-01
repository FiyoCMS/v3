<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


$api 	= Input::get('api');
$act 	= Input::get('act');
$view 	= Input::get('view');
$print 	= Input::get('print');

if(!$api AND !$print) :
switch($act)
{
	case 'add':	 
	 require('view/add.php');
	break;
	case 'edit':
	 require('view/edit.php');
	break;
	default :
	 require('view/default.php');
	break;
}

else :
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
		default :
			page('404');
		break;
	}

	if($print)
	switch($print)
	{
		case 'sample':	 
		require('print/sample.php');
		break;
		default :
			page('404');
		break;
	}
endif;