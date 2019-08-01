<?php
/**
* @version		v 1.0.0
* @package		Fi ImageSlider
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, thanks to WOWSlider :)
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$type 	= mod_param('type',$modParam);
$folder = mod_param('folder',$modParam);
$theme 	= mod_param('theme',$modParam);
$effect = mod_param('effect',$modParam);
$imgW 	= mod_param('imgW',$modParam);
$imgH	= mod_param('imgH',$modParam);
$slideD = mod_param('slideD',$modParam);
$strecth = mod_param('strecth',$modParam);
$effectD = mod_param('effectD',$modParam);

$dirs = @opendir("media/$folder");
if(!$dirs): 
	echo "Error :: folder <b>media/$folder</b> not exists !";
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
<div id="wowslider-container" style="height:<?php echo $imgH;?>px";>
	<div class="ws_images">
		<?php
			$no = 0;
			while($file=readdir($dirs)){ 
				if($file=="." or $file=="..")continue; 
				if(preg_match("/.$type/",$file))						
					echo "<span><img src='".FUrl."media/$folder/$file' align=\"left\" id='wows$no'></a></span>";
			$no++;
			} 	
			closedir($dirs);	
		?>
	</div>
	<div class="ws_shadow"></div>
</div>			

<?php	

if($effect =='squares')
	require('effect/squares.php');
else if($effect =='fades')
	require('effect/fades.php');
else if($effect =='blast')
	require('effect/blast.php');
else if($effect =='kenburns')
	require('effect/kenburns.php');
else
	require('effect/basic.php');
	
$imgSlider += 1;
endif;
?>	
