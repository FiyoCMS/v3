<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

if(USER_LEVEL > 2) die ();
defined('_FINDEX_') or die('Access Denied');


/****************************************/
/*	    Enable and Disbale User		*/
/****************************************/
$stat 	= Input::get('stat');
$id 	= Input::get('id');
if($stat =='1'){
	DB::table(FDBPrefix.'user')->where('id='.$id)->update(array("status"=>"1"));
		alert('success',Status_Applied,1);
}
else if($stat == '0'){
	DB::table(FDBPrefix.'user')->where('id='.$id)->update(array("status"=>"0"));
	DB::table(FDBPrefix.'session_login')->delete('user_id='.$id);
	alert('success',Status_Applied,1);
}
else if($stat == 'kick'){
	DB::table(FDBPrefix.'session_login')->delete('user_id='.$id);
	alert('success',Status_Applied,1);	
}