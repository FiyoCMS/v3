<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


$view = Input::get('view');
$folder = Input::get('folder');
$act 	= Input::get('act');
$api 	= Input::get('api');

			
if(!$api)
if($view == 'layout') {
    switch ($act) {
        case "add" :
	    require('layout/add_layout.php');
    break;
        case "edit" :
	 require('layout/edit_layout.php');
            break;
        default : 
	 require('layout/view_layout.php');
            break;
        
    }         
}
else if($view == 'admin')
	 require('admin_theme.php');
else if($folder AND $folder != 'blank') 
	 require('edit_theme.php');
else
	 require('site_theme.php');

if($api)
switch($api)
{
    case 'module':	 
        $module = app_param('module');
	 require("themes/" .siteConfig('admin_theme') . "/$module.php");
	break;
}