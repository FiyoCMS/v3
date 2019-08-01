<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');


$view 	= app_param('view');

define("USER_TBIB", Input::session('PEGAWAI_SESSION_LOGIN'));



switch($view)
{
	case 'logout':		
        $_SESSION['PEGAWAI_LAST_DATA'] = null;
        unset($_SESSION['PEGAWAI_LAST_DATA']);
        redirect(FUrl);
	break;
	
}

if(Input::post('kategori') == 1) {
	$data 	= Input::$post;
	if(!Input::post('id')) {
		if(Mutasi::simpan_antarkab($data)) refresh();
		
	}
	else {
		
		if(Mutasi::edit_antarkab($data)) refresh();	
	}
}

if(Input::post('edit-antarkab')) {	
	$data 	= Input::$post;
	if(Mutasi::edit_antarkab($data)) refresh();	
}

if(Input::post('edit-antarskpd')) {	
	$data 	= Input::$post;
	if(Mutasi::edit_antarskpd($data)) refresh();	
}

if(Input::post('simpan-kabkemen')) {	
	$data 	= Input::$post;
	if(Mutasi::simpan_kabkemen($data)) redirect(make_permalink('?app=mutasi&view=profil'));	
}

if(Input::post('simpan-antarkab')) {	
	$data 	= Input::$post;
	if(Mutasi::simpan_antarkab($data)) redirect(make_permalink('?app=mutasi&view=profil'));	
}

if(Input::post('simpan-antarskpd')) {	
	$data 	= Input::$post;
	if(Mutasi::simpan_antarskpd($data)) redirect(make_permalink('?app=mutasi&view=profil'));	
}


if(Input::post('simpan-kabskpd')) {	
	$data 	= Input::$post;
	if(Mutasi::simpan_kabskpd($data)) redirect(make_permalink('?app=mutasi&view=profil'));	
}


if(Input::post('login')) {	
	$user = Input::post('username');
	$pass = Input::post('password');
	$data = User::loginPNS($user, $pass);
	if($data) {
		 Input::setSession('USER_SINAGA', $data[0]);
	}
}

if(!defined('PageTitle'))
define('PageTitle','Lembar Mutasi');

