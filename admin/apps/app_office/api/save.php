<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 2) die ();
header('Content-Type: application/json');

//Check CSRF Token AND $data
$data = Input::$post;
if(!$data OR $data['_token'] != USER_TOKEN) die('Access Denied');

if(!empty($data['mod_id']))
$qr = Query::update($data, $data['mod_id']);
else
$qr = Query::add($data);

       
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