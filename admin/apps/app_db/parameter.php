<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
	
//membuat parameter $app
$app = [
	'name'		=> 'DB Helper',
	'table'		=> '',
	'folder'	=> 'app_'.$_REQUEST['app'],
	'root'		=> $_REQUEST['app'],
	'index'		=> ''
];
