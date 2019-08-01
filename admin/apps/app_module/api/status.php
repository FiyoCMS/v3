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
$stat = Input::get('stat');
$name = Input::get('name');
$qr = false;
if($stat == '1' OR $stat == '0' ) {
    $qr = DB::table(FDBPrefix.'module')
    ->where('id='.$id)
    ->update(array("status"=> $stat));
}

		
/****************************************/
/*		   Enable and Disbale Nam		*/
/****************************************/ 	
if($name == '1' OR $name == '0' ) {
    $qr = DB::table(FDBPrefix.'module')
    ->where('id=' .$id)
    ->update(array("show_title" => $name));
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
        'text' => Status_Error
    ];
} 

echo json_encode($return);
