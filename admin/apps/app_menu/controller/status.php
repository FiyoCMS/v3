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
/*	    Enable and Disbale Article		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		DB::table(FDBPrefix.'menu')->where('id='.$_GET['id'])->update(array("status"=>"1"));
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		DB::table(FDBPrefix.'menu')->where('id='.$_GET['id'])->update(array("status"=>"0"));
		alert('success',Status_Applied,1);
	}
}

		
/****************************************/
/*		      Make Home Page			*/
/****************************************/ 	
if(isset($_GET['home'])) {
	$qr = DB::table(FDBPrefix.'menu')->where('id!='.$_GET['id'])->update(array("home"=>"0"));
	$qr = DB::table(FDBPrefix.'menu')->where('id='.$_GET['id'])->update(array("home"=>"1"));
	if($qr) alert('success',Status_Applied,1);
}

		
/****************************************/
/*		    Make Default Page			*/
/****************************************/ 	
if(isset($_GET['default'])) {
	alert('success',$_GET['id']);
	$qr = DB::table(FDBPrefix.'menu')->where('id!='.$_GET['id'])->update(["global"=>"0"]);
	$qr = DB::table(FDBPrefix.'menu')->where('id='.$_GET['id'])->update(["global"=>"1"]);
	if($qr) alert('success',Status_Applied,1);
}

?>
<script>notice();</script>