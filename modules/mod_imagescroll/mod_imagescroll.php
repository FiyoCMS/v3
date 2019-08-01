<?php
/**
* @version		v 1.0.0
* @package		Fi ImageScroll
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$type = mod_param('type',$modParam);
$thumb = mod_param('thumb',$modParam);
$style = mod_param('style',$modParam);
$folder = mod_param('folder',$modParam);
$thumbW = mod_param('thumbW',$modParam);
$thumbH = mod_param('thumbH',$modParam);
$boxW = mod_param('boxW',$modParam);
$boxH = mod_param('boxH',$modParam);

$dir = @opendir("files/$folder");
if(!$dir) 
	echo "error :: folder images not exists !";
else
{
	if(!isset($imgScroll)) {
		$imgScroll = 1;
		addJs(FUrl."modules/$modFolder/js/img_scroll.js");		
		addCss(FUrl."modules/$modFolder/style/style$style/style.css");
		addCss(FUrl."modules/$modFolder/css/style.css");
		$imgScroll += 0;	
	}
	
	$wm = $boxW-50;
	echo "
	<script type='text/javascript'>
		$(document).ready(function () {
		 $('.fiyoCarousel$imgScroll').fiyoCarousel();
		});
	</script>
		
	<style>

	.fiyoCarousel$imgScroll {
	  width: ".$boxW."px;
	  position: relative;
	}

	.fiyoCarousel$imgScroll .wrapper {
	  width: ".$wm."px;
	  overflow: hidden;
	  min-height: ".$boxH."px;;
	  margin-left: 22px;
	  position: absolute;
	  top: 0;
	}
	.fiyoCarousel$imgScroll ul li {
	  height:".$thumbH."px;
	  width: ".$thumbW."px;
	 }
	 </style>
	 ";

	?>
	<div class="fiyoCarouselBg" style="height:<?php echo $boxH; ?>px">
		<div class="fiyoCarousel <?php echo "fiyoCarousel$imgScroll"; ?>">
			<div class="wrapper">
				<ul>
				<?php
				while($file=readdir($dir)){ 
					if($file=="." or $file=="..")continue; 
					if(preg_match("/.$type/",$file))
					{
						if($thumb==1){
					echo "<li><a href='".FUrl."files/$folder/$file' class=\"popup\"><img src='".FUrl."files/.thumbs/$folder/$file' align=\"left\" width='$thumbW' height='$thumbH'></a></li>";
						}
						elseif($thumb==0){
					echo "<li><a href='".FUrl."files/$folder/$file' class=\"popup\"><img src='".FUrl."files/$folder/$file' align=\"left\" width='$thumbW' height='$thumbH'></a></li>";
						}
					 }
				} 
				closedir($dir);
				?>
				</ul> 
			</div>
		</div>
	</div>		
<?php
	$imgScroll += 1;
}
?>	
