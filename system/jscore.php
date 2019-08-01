<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

/*
if(!isset($_SERVER['HTTP_REFERER']) or !defined('_FINDEX_')) die('Access Denied!');
*/
//memuat file pendukung jsquery dan fungsi lainya
require_once ('../../../config.php');
require_once ('../../../system/controller.php');
require_once ('../../../system/database.php');
require_once ('../../../system/input.php');
require_once ('../../../system/function.php');
require_once ('../../../system/user.php');
require_once ('../../../system/site.php');


//check table setting
if(!DB::tableExists(FDBPrefix."setting")) die("Table setting not found!");

//set timezone
$time = siteConfig('timezone');
if($time) date_default_timezone_set(siteConfig('timezone'));