<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

// Access only for Administrator
if($_SESSION['USER_LEVEL'] > 2)
	redirect('index.php');
	

require_once('model/query.php');

$app 	= $_REQUEST['app']; 
$table 	= FDBPrefix.$_REQUEST['app']; 
	
	
//Add new data
if(Input::post('save')) {	
	$data 	= Input::$post;
	if(Query::add($data)) redirect('?app='.$app);	
}


//Update data
if(Input::post('edit')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update($data, $id)) refresh();	
}

//Delete Data
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
