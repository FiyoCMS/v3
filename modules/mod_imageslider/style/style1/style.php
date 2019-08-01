<?php 

if($imgW <= 400)
	$bg = "url($path/style/style1/shadow350.png)";
else if($imgW <= 600)
	$bg = "url($path/style/style1/shadow550.png)";
else if($imgW <= 800)
	$bg = "url($path/style/style1/shadow750.png)";
else if($imgW > 800)
	$bg = "url($path/style/style1/shadow.png)";
$imageSliderCss = "
/* bottom center */

#wowslider-container { 
/*	overflow: hidden; */
	zoom: 1; 
	position: relative; 
	width:".$imgW."px;
	height:".$imgH."px;
	margin:0 auto;
	z-index:100;
}
#wowslider-container .ws_shadow{
	width:100%; 
	background: $bg no-repeat bottom;
	height:".$imgH."px;
	position: absolute;
	left:0;
	bottom:-30px;
	z-index:-1;
}
#wowslider-container .ws_images{
	position: absolute;
	left:0px;
	top:0px;
	width:".$imgW."px;
	height:".$imgH."px;
	box-shadow: 0 0 8px #888;
}
";