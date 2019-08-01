<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 2 AND !Input::get('stat')) die ();
/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/
$id = Input::get('id');
$qr = false;
if(Input::get('stat') == 0 OR Input::get('stat') == 1) {
	$qr = DB::table(FDBPrefix.'menu')->where('id='.$id)->update(array("status"=> Input::get('stat')));
}

		
/****************************************/
/*		      Make Home Page			*/
/****************************************/ 	
if(Input::get('home')) {
	$qr = DB::table(FDBPrefix.'menu')->where('id!='.$id)->update(array("home"=>"0"));
	$qr = DB::table(FDBPrefix.'menu')->where('id='.$id)->update(array("home"=>"1"));
}

       
if($qr) {
    $return = [
        'status' => 'success',
        'text' => Status_Saved
    ];
}
else {
    $return = [
        'status' => 'error',
        'text' => Status_Fail
    ];
} 

echo json_encode($return);