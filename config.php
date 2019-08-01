<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description 	Database Configuration


**/

if($_SERVER['SERVER_ADDR'] == '127.0.0.1' or $_SERVER['SERVER_ADDR'] == '::1' ) {
    $DBName	= 'fiyo_gis_dwi';
    $DBHost	= '127.0.0.1';
    $DBUser	= 'root';
    $DBPass	= '';
    $DBPrefix	= 'web_';

} else {
    $DBName	= 'fiyo_gis_dwi';
    $DBHost	= '127.0.0.1';
    $DBUser	= 'root';
    $DBPass	= '';
    $DBPrefix	= '';
}




