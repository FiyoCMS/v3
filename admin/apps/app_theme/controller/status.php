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
/*	   		  	Site Theme				*/
/****************************************/
if(isset($_GET['type']) AND $_GET['type'] =='site') {
	if(isset($_GET['theme'])){
		DB::table(FDBPrefix.'setting')->where("name='site_theme'")->update(array("value"=>$_GET['theme']));
		alert('success',Theme_successfully_applied,1);
	}
}
/****************************************/
/*	   		  	Admin Theme				*/
/****************************************/
if(isset($_GET['type']) AND $_GET['type'] =='admin') {
	if(isset($_GET['theme'])){
		DB::table(FDBPrefix.'setting')->where("name='admin_theme'")->update(array("value"=>$_GET['theme']));
		alert('success',Theme_successfully_applied,1);
		
	}
}

?>
<script>notice();</script>