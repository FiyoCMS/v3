<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(!USER_LEVEL AND !Input::get('stat') or !Input::get('id')) die ();

$stat = Input::get('stat');
/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/

if($stat=='1'){
	DB::table(FDBPrefix.'comment')->where('id='.Input::get('id'))->update(array("status"=>$stat));
	alert('success',Status_Applied,1);
}else {
	DB::table(FDBPrefix.'comment')->where('id='.Input::get('id'))->update(array("status"=>$stat));
	alert('success',Status_Applied,1);
}