<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


/********************************************/
/*             Set Layout Menu              */
/********************************************/
define("FLayout", Site::$layout);
define("FLayoutName", preg_replace('/\s+/', '', strtolower(Site::layout("name"))));


function loadModule($position, $echo = false) {	
	if(Site::$status == false) return false;

	
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
		return "<div class='theme-module'>$position</div>";
	} 
	else {
		ob_start();
		$qrs = DB::table(FDBPrefix.'module')
			->where("status=1 AND position='$position'" .Level_Access)
			->orderBy('short ASC')
			->get();
			
		if($qrs)
		foreach($qrs as $qr){
			if(!empty($qr['page'])) {
				$page = explode(",",$qr['page']);
				foreach($page as $val)
				{
					if(FLayout == $val)
					{ 	
						$qr['show_title']== 1 ? $title="<h3>$qr[name]</h3>" : $title = "";						
						echo "<div class=\"modules $qr[class]\">$title<div class=\"mod-inner\" style=\"$qr[style]\">";
						$modId = $qr['id'];
						$modParam = $qr['parameter'];
						if(checkLocalhost()) {
							$modParam = str_replace(FLocal."media/","media/",$modParam);
							$modParam = str_replace("/media/",FUrl."media/",$modParam);			
						}
						$modFolder = $qr['folder'];
						$theme = siteConfig('site_theme');
						$tfile = "themes/$theme/modules/$qr[folder]/$qr[folder].php";	
						$file = "modules/$qr[folder]/$qr[folder].php";	
						if(file_exists($tfile))
							include($tfile);
						else if(file_exists($file))
							include($file);
						else
							echo "<i>Module Error</i> : <b>$qr[folder]</b> is not installed!";
						echo"</div></div>";
					}
				}
			}
			
			else if($qr['page']==FLayout AND FUrl==$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']){
				if($qr['show_title']==1){$title="<h3>$qr[name]</h3>";}
				else {$title="";}
				echo "<div class=\"modules $qr[class]\">$title<div class=\"mod-inner\" style=\"$qr[style]\">";
				$tfile 	= "themes/$theme/modules/$qr[folder]/$qr[folder].php";	
				$file	="modules/$qr[folder]/$qr[folder].php";	
				$modId 	= $qr['id'];
				$modFolder 	= $qr['folder'];
				$modParam 	= $qr['parameter'];
				if(checkLocalhost()) {
					$modParam = str_replace(FLocal."media/","media/",$modParam);
					$modParam = str_replace("/media/",FUrl."media/",$modParam);			
				}
				if(file_exists($tfile))
					include($tfile);
				else if(file_exists($file))
					include($file);
				else
					echo "Module Error : <b>$qr[folder]</b> is not installed!";
				echo"</div></div>";
			}
		}
		$mod = ob_get_contents();
		ob_end_clean();
		if($echo == true)
		return $mod;
		else
		echo $mod;
	}
}

function checkModule($position) {
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
		return true;
	}
	else {	
		if(!defined('FLayout') AND $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']==FUrl){
			$qr = DB::table(FDBPrefix.'menu')->where('home=1')->get()[0]; 
			$pid = $qr['id'];
		}
		else{	
			$pid = FLayout;
			if(empty($pid)) $pid = 0;
		}

		$val = false;
		if(!is_array($position)) $where = " position = '$position'";
		else $where = " position IN('".implode("','",$position)."')";
		$sq = DB::table(FDBPrefix.'module')->where("status=1 AND $where" .Level_Access)->orderBy('short ASC')->get();
		
		if($sq)
		foreach($sq as $qr){
			if(!empty($qr['page'])) {
				$pid = explode(",",$qr['page']);
				foreach($pid as $a) {
					if($a == FLayout )
					$val = true;
				}
			}		
		}
		return $val;
	}
}


function loadModuleCss() {
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
	echo "<style>.theme-module {
		border: 2px solid #e3e3e3; 
		background: rgba(250,250,250,0.8);
		color : #666; 
		padding: 10px;
		margin: 5px 3px;
		font-weight: bold;
		cursor: pointer;
		transition: all .2s ease;
		}
		.theme-module:hover {
		border-color: #ff9000; 
		background: rgba(255, 205, 130,0.15);
		color : #ff6100;
		box-shadow: 0 0 10px #ffcd82;} </style>";
	}
	else {	
		if(!defined('FLayout') AND $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']==FUrl){
			$qr = DB::table(FDBPrefix.'menu','*','home=1'); 
			$pid= $qr['id'];
		}
		else{	
			$pid = FLayout;
			if(empty($pid)) $pid = 0;
		}
		$val = false;
		$no = 1;
		$qr = DB::table(FDBPrefix.'module')->where('status=1')->orderBy('short ASC')->get();

		if($qr)
		foreach($qr as $qr){
			if(!empty($qr['page'])) {
				$pid = explode(",",$qr['page']);
				foreach($pid as $a) { 
					if($a == FLayout ) {
						$file	= "modules/$qr[folder]/mod_style.php";
						if(file_exists($file)) {
							require_once ($file);
							$no++;
						}	
					}
				
				}
			}		
		}	
	}
}