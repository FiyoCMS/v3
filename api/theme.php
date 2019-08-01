<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


defined('_FINDEX_') or die('Access Denied');

if(!Input::get('module')) die('Access Denied');
$file = FAdminPath. "/module/". Input::get('module') .".php";
if(file_exists($file))
    include_once($file);