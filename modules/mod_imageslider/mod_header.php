<?php
/**
* @version		v 1.0.0
* @package		Fi ImageSlider
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, thanks to WOWSlider :)
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$imgW = mod_param('imgW',$modParam);
$imgH = mod_param('imgH',$modParam);

if(!$dirs): 
	echo "Error :: folder images not exists !";
else:
	if(!isset($imgSlider)) {
		$imgSlider = 1;
		addCss(FUrl."modules/mod_imageslider/style/style$theme/style.css");
		addJs(FUrl."modules/mod_imageslider/engine/wowslider.js");
		$imgSlider += 0;	
	}	
	echo "
	<style>
	#featured .ui-tabs-panel{ 
	width:".$imgW."px;
	height:".$imgH."px;
	background:#999; position:relative;
	overflow:hidden;
	}	
	</style>";	
?>	