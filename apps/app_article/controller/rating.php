<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Rating
**/

session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');

if(!Input::post('id')) { 
	alert('error','Access Denied!',true,true);
	die();
} 
else if(Input::post('do') AND Input::post('id')) {
	$id = (int)Input::post('id');	
	$param = oneQuery('article','id',$id,'parameter');
	
		if($_POST['do']=='rate'){
			$rating = $_POST['rating'];
			$va = mod_param('rate_value',$param);
			$rating += $va;
			$vo = mod_param('rate_counter',$param);
			
			if(!is_numeric($vo) or !is_numeric($va)) $vo1 = 0;
			$vo1 = $vo+1;
			
			$pva = strpos($param,"rate_value=$va");
			if($pva)		
				$param = str_replace("rate_value=$va","rate_value=$rating",$param);
			else		
				$param .= "rate_value=$rating".";\n";
				
				
			$pvo = strpos($param,"rate_counter=$vo");
			if($pvo)	
			$param = str_replace("rate_counter=$vo","rate_counter=$vo1",$param);
			else
				$param .= "rate_counter=$vo1".";\n";
			
			$param = strip_tags($param);
			if(DB::table(FDBPrefix.'article')->where('id='.$id)->update(["parameter"=>"$param"])) {
				$_SESSION["article_rate_$id"] = true;
				return true;
			}
			else
				return false;
		}
		else if(Input::post('do')=='getrate'){
			$va = mod_param('rate_value',$param);
			$vo = mod_param('rate_counter',$param);
			$rating = (@round($va / $vo,1)) * 20; 
			echo $rating;					
		}		
}
