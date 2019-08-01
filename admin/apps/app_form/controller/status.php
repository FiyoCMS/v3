<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2 AND !isset($_GET['stat'])) die ();
define('_FINDEX_','BACK');
require_once ('../../../system/jscore.php');

/****************************************/
/*	    Enable and Disbale Modules		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		DB::table(FDBPrefix.'module')->where('id='.$_GET['id'])->update(array("status"=>"1"));
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		DB::table(FDBPrefix.'module')->where('id='.$_GET['id'])->update(array("status"=>"0"));
		alert('success',Status_Applied,1);
	}
}
/****************************************/
/*	    Enable and Disbale Name			*/
/****************************************/
if(isset($_GET['name'])) {
	if($_GET['name']=='1'){
		DB::table(FDBPrefix.'module')->where('id='.$_GET['id'])->update(array("show_title"=>"1"));
		alert('success',Status_Applied,1);
	}
	if($_GET['name']=='0'){
		DB::table(FDBPrefix.'module')->where('id='.$_GET['id'])->update(array("show_title"=>"0"));
		alert('success',Status_Applied,1);
	}
}