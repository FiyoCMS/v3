<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$app_name			= 'TBIB';
$app_version		= '2.0';
$app_date			= '9 February 2018';
$app_author			= 'Fiyo CMS';
$app_author_url		= 'http://www.fiyo.org';
$app_author_email	= 'info@fiyo.org';
$app_desc 			= 'Aplikasi Mutasi BKD 2018';


//membuat parameter $app
$app = [
	'name'		=> 'Tugas Belajar dan Ijin Belajar',
	'table'		=> FDBPrefix.'tbib',
	'folder'	=> 'app_'.app_param('app'),
	'root'		=> app_param('app'),
	'index'		=> 'id_tbib'
];


?>
