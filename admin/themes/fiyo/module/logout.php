<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
define('_FINDEX_','BACK');
require('../../../system/jscore.php');


$login = User::logout();