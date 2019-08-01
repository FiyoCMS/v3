<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 2) die ();
header('Content-Type: application/json');


/****************************************/
/*	    Enable and Disbale Modules		*/
/****************************************/
$id = Input::get('id');
$qr = false;
if(Input::get('stat') == 0 OR Input::get('stat') == 1) {
	$qr = DB::table(FDBPrefix.'module')->where('id='.$id)->update(array("status"=> Input::get('stat')));
}

		
/****************************************/
/*		      Enable and Disbale Nam			*/
/****************************************/ 	
if(Input::get('name') == 0 OR Input::get('name') == 1) {
	$qr = DB::table(FDBPrefix.'module')->where('id='.$id)->update(array("show_title"=> Input::get('name')));
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
