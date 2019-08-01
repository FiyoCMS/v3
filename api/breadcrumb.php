<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


defined('_FINDEX_') or die('Access Denied');

if(!User::logged_in()) die();

$link =  Input::get('data');
$link = str_replace("@", "&", $link);
$app = link_param('app', $link);
$cat = link_param('cat' , $link);
	
if(isset($app)) {
	$mns = oneQuery("menu","sub_name","$app","name");
	$md = menuInfo('name',"?app=$app");	
}


//set nama
$mn = menuInfo('name',$link);

//set parent menu
$np = menuInfo('parent_id',$link);

//set nama Menu dari parent
$mp = menuInfo('name',$link,menuInfo('parent_id',$link));

//set link menu dari parent
$ml = menuInfo('link',$link,menuInfo('parent_id',$link));

ob_start(); 
?>
<ul id="breadcrumbs" class="breadcrumb stats"> 
    <li><a href="index.php"><i class="icon-home"></i>Dashboard</a></li>
	<?php 
	if(!empty($mp) AND !empty($app) AND $np) {
		if(!$mn) {
            $mdl = menuInfo('name',"?app=$app",menuInfo('parent_id',"?app=$app"));
            
			if($mdl)
                echo "<li><a href='#'>$mdl</a></li>";	
                	
			$mn = $md;
		
		} else if (!empty($mp)) {
			if($mp !== 'Apps') 
				$ml = "?app=$app";			
			echo "<li><a href='$ml'>$mp</a></li>";
		}	
		if (!empty($cat) && $app == 'menu') {
			echo "<li><a href='#'>".ucfirst($cat)."</a></li>";
		}
		else if(!empty($mn) || !isset($cat)) 
			echo "<li><a href='#'>$mn</a></li>";
		
	} else if(!empty($mns) && !empty($app))  { 
		echo "<li><a href='#'>$mns</a></li>";
	} else if($app) {		
		$ml = "?app=$app";		
		$parent = menuInfo('parent_id',"$ml");
		if(!$parent) {	
			$url = menuInfo('id',"$ml");
			$name = menuInfo('name',$url, $url);
			$url2 = menuInfo('link',$url, $url);
			echo "<li><a href='$url2'>$name</a></li>";
		} else {			
			$name = menuInfo('name',$ml);
			$url = menuInfo('link', $ml);
			echo "<li><a href='$url'>$name</a></li>";
		}
	}
	?>
</ul> 
<?php

$html = ob_get_contents();
ob_end_clean();

$valid = true;
if($valid){
    $response = [
        'status'    => 'ok', 
        'code'      => '200', 
        'text'      => $link,
        'html'      => $html
    ];
}
else { 
    $response = [
        'status'    => 'error', 
        'code'      => '200', 
        'text'      => '',
        'html'      => $html
    ];
}

echo json_encode($response);