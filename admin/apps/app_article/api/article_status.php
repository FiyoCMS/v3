<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(!USER_LEVEL AND !Input::get('fp') or !Input::get('id')) die ();


/****************************************/
/*	    	Article Front Page			*/
/****************************************/
if(isset($_GET['fp'])) {
	if($_GET['fp']=='1'){
		DB::table(FDBPrefix.'article')->where('id='.Input::get('id'))->update(array("featured"=>1));
		alert('success',Status_Applied,1);
	}
	if($_GET['fp']=='0'){
		DB::table(FDBPrefix.'article')->where('id='.Input::get('id'))->update(array("featured"=>0));
		alert('success',Status_Applied,1);
	}
}

/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		DB::table(FDBPrefix.'article')->where('id='.Input::get('id'))->update(array("status"=>1));
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		DB::table(FDBPrefix.'article')->where('id='.Input::get('id'))->update(array("status"=>0));
		alert('success',Status_Applied,1);
	}
}