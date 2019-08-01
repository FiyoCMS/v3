<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
**/


if(!defined('_FINDEX_'))
{
	ob_start();
	session_start();

	//set mulai session
	//mendefinisikan _FINDEX_ sebagai halaman utama
	define('_FINDEX_', 'BACK' );

	define('_SHOW_ERROR_', TRUE );

	$start_time = microtime(TRUE);
	define('_START_TIME_', $start_time );

	//Show Error!
	if(_SHOW_ERROR_) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		ini_set("log_errors", 1);
		if($_SERVER['SERVER_ADDR'] == '127.0.0.1' or $_SERVER['SERVER_ADDR'] == '::1' )
			ini_set("error_log", __dir__."/error_local.log");
		else 
			ini_set("error_log", __dir__."/error.log");	
	}

	//mengecek file konfigurasi
	if(!file_exists('../config.php')) 
		header("location:../");
		
	$sn = substr($_SERVER['PHP_SELF'],1);
	$sm = strpos($sn,'/');
	$sm = substr($sn,0,$sm);
	define('_ADMINPANEL_', $sm );

	require_once ('system/core.php');
} else {
		
	define('_ADMINPANEL_', basename(__dir__));

	//memuat file pendukung query dan fungsi lainya
	require_once ('system/rcore.php');

}