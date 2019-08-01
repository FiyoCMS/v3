<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

abstract class Controller { 
	public static $is_error = false;
	public static $error;
	
    protected $middleware = [];
	
	public static function setError() {
		self::$is_error = true;
	}
	public static function getError() {		
		return self::$is_error;		
	}
	
	public static function pushError($value) {
		self::$error = $value;
	}
}


class_alias('Controller', 'Core');