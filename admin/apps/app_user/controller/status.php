<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2) die ();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 

/****************************************/
/*	    Enable and Disbale User		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		DB::table(FDBPrefix.'user')->where('id='.$_GET['id'])->update(array("status"=>"1"));
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		DB::table(FDBPrefix.'user')->where('id='.$_GET['id'])->update(array("status"=>"0"));
		$db::table(FDBPrefix.'session_login')->delete('user_id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='kick'){
		$db::table(FDBPrefix.'session_login')->delete('user_id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
}