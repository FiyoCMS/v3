<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$act	= Input::post('act');
$uname 	= Input::post('username');
$email 	= Input::post('email');
switch($act)
{
	default :
		if(strlen($uname) <4) echo 2;
		else{
			$user = oneQuery("user","user","$uname");
			echo $user;
		}
	break;
	case 'email':	
		if(!preg_match("/^.+@.+\\..+$/", $email) or substr_count($_POST['email'],"@")>1) echo 2;
		else {
			$email = oneQuery("user","email","$email");
			echo $email;
		}
	break;
}
