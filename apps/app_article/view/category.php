<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if(Article::categoryInfo('name', app_param('id'))) {
	$article = Article::category('category', app_param('id'), 'default');
	require	("format/$format.php");
	//print_r($article);
}
else {
	echo _404_;
}