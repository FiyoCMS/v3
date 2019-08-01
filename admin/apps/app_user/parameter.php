<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

//Router File
defined('_FINDEX_') or die('Access Denied');


//membuat parameter $app
$app = [
	'name'		=> 'User',
	'table'		=> FDBPrefix.$_REQUEST['app'],
	'folder'	=> 'app_'.$_REQUEST['app'],
	'root'		=> $_REQUEST['app'],
	'index'		=> 'id'
];

