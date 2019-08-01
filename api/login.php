<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


if(!Input::get('user') or !Input::get('pass') AND  !Input::get('password')) die('Access Denied');

$user = addslashes(Input::get('user'));
$pass = Input::get('pass');
if(empty($pass))
    $pass = Input::get('password');

$login = User::login($user, $pass);
        
if($login AND Input::session('USER_LEVEL') <= siteConfig('special_level') AND userInfo()){
    $response = [
        'status'    => 'ok', 
        'code'      => '200', 
        'text'      => Login_Success,
        'html'      => alert('success',Login_Success)
    ];
}
else { 
    $response = [
        'status'    => 'error', 
        'code'      => '200', 
        'text'      => Login_Error,
        'html'      => alert('error',Login_Error)
    ];
}

echo json_encode($response);