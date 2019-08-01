<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');



/****************************************/
/*		      Delete Tag				*/
/****************************************/ 	
if(Input::post('delete_id')){
	$source = Input::post('delete_id');
	$source = multipleSelect($source);
	$delete = multipleDelete($app['table'],$source,'',$app['index']);	
	if(isset($delete)){
		notice('info',Status_Deleted);
		refresh();
	}
	else {
		notice('error',Please_Select_Item);
		refresh();
	}
}	


	
//Add Data
if(Input::post('add')) {
	$data 	= Input::$post;
	if(Query::add_vendor($data)) redirect("?app=$app[root]");
}

//Edit Data
if(Input::post('edit')) {
	$data 	= Input::$post;
	$id = Input::get('id');
	if(Query::edit_vendor($data, $id)) refresh();
}

// Redirect when User-Id not found
if(Input::get('act') == 'edit' AND !Input::post('edit')) {
	if(Input::get('act'))
	if($_REQUEST['act'] == 'edit' AND !Req::get('view')){
		$id = (int)Input::get('id');
		$row = Database::table($app['table'])->where("id=$id")->get(); 
		$jml=count($row);
		if($jml <= 0) {
			notice('info','Sorry, data refference not found');
			redirect("?app=$app");
		}
	}
}
