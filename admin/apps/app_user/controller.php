<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

require_once('model/query.php');
//require_once('model/funct.php');

$app 	= $_REQUEST['app']; 
$table 	= FDBPrefix.$_REQUEST['app']; 

if(Input::post('save')) {	
	$data 	= Input::$post;
	if(Query::add($data)) redirect('?app='.$app);	
}

if(Input::post('edit')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update($data, $id)) refresh();	
}

if(Input::post('delete_confirm')) {	
	$source = Input::post('check');
	$source = multipleSelect($source);
	$delete = multipleDeletes($table, $source);


	if($delete  == 'deleted') {			
		notice('info',Status_Deleted);
		refresh();	
	}
	else if($delete  == 'cantdelete') {		
		notice('error',Status_Cant_Delete);
		refresh();	
	}
	else if($delete  == 'noempty'){
		notice('error',Status_Not_Empty);
		refresh();	
	}
	else
		notice('error',Please_Select_Item);
	
}


if(Input::post('check_group')) {	
	$source = Input::post('check_group');
	$source = multipleSelect($source);
	$delete = multipleDelete('user_group',$source,'user','level','level <= 4');


	if($delete  == 'deleted') {			
		notice('info',Status_Deleted);
		refresh();	
	}
	else if($delete  == 'cantdelete') {		
		notice('error',Status_Cant_Delete);
		refresh();	
	}
	else if($delete  == 'noempty'){
		notice('error',Status_Not_Empty);
		refresh();	
	}
	else
		notice('error',Please_Select_Item);
	
}
/******************************/

if(Input::post('save_group')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::add_group($data, $id)) redirect('?app='.$app.'&view=group');	
}

if(Input::post('edit_group')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update_group($data, $id)) refresh();	
}




// Redirect when User-Id not found
if(Input::get('act') == 'edit' AND !Input::post('edit')) {
	if(Input::get('act'))
	if($_REQUEST['act'] == 'edit' AND !Req::get('view')){
		$id = (int)Input::get('id');
		$row = Database::table($table)->where("id=$id")->get(); 
		$jml=count($row);
		if($jml <= 0) {
			notice('info','Sorry, data refference not found');
			redirect("?app=$app");
		}
	}
}

	
