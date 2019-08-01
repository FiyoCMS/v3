<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


defined('_FINDEX_') or die('Access Denied');

if(userInfo()) die();
$user = addslashes(Input::get('user'));
$pass = Input::get('pass');
$login = User::login($user, $pass);
	
if($login AND $_SESSION['USER_LEVEL'] <= siteConfig('special_level') AND userInfo()){
	echo "{ \"status\":\"1\" , \"alert\":\"".alert('success',Login_Success)."\"}";	
}
else {
	echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',Login_Error)."\"}";	
}