<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');


function loadPluginCss() {	
	$qr = DB::table(FDBPrefix.'plugin')->where('status=1')->get();	
	foreach($qr as $qr){	
		$folder = "plugins/$qr[folder]/plg_css.php";
		if(file_exists($folder))
			include($folder);
	}	
}

function loadPluginJs() {	
	$qr = DB::table(FDBPrefix.'plugin')->where('status=1')->get();	
	foreach($qr as $qr){	
		$folder = "plugins/$qr[folder]/plg_js.php";
		if(file_exists($folder))
			include($folder);
	}
}

//load active plugins
loadPlugin();