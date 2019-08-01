<?php

echo '
<script>	
	function ws_fade(b,a){var c=jQuery;a.each(function(d){if(!d){c(this).show()}else{c(this).hide()}});this.go=function(d,e){c(a.get(d)).fadeIn(b.duration);c(a.get(e)).fadeOut(b.duration);return d}};	
	jQuery("#wowslider-container").wowSlider({effect:"fade",prev:"",next:"",duration:20*'.$effectD.',delay:20*'.$slideD.',outWidth:645,outHeight:360,width:645,height:360,autoPlay:true,stopOnHover:false,loop:false,bullets:true,caption:true,controls:true});
</script>';