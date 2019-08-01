<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

require_once('model/query.php');
require_once('model/funct.php');

// Access only for Administrator
if($_SESSION['USER_LEVEL'] > 2)
	redirect('index.php');
	
if(Input::post('save')) {	
	$data 	= Input::$post;
	if(Query::add($data)) redirect('?app='.$app['root'].'&act=edit&id='.DB::$last_id);
}

if(Input::post('edit')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update($data, $id)) refresh();	
}

if(Input::post('add_category')) {	
	$data 	= Input::$post;
	if(Query::add_category($data)) redirect('?app='.$app['root'].'&cat='.$data['category']);	
}

if(Input::post('apply_category')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update_category($data, $id)) refresh();	
}

if(Input::post('delete_confirm')) {	
	$source = Input::post('check');
	$source = multipleSelect($source);
	$delete = multipleDeletes($app['table'], $source);

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
		$row = Database::table($app['table'])->where("id=$id")->get(); 
		$jml=count($row);
		if($jml <= 0) {
			notice('info','Sorry, data refference not found');
			redirect("?app=$app");
		}
	}
}


/****************************************/
/*			Delete category menu		*/
/****************************************/
if(isset($_POST['delete_category']) or isset($_POST['check'])){
	$source = $_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('menu_category',$source,'menu','category');
	if($delete == 'noempty') {
		notice('error',Category_Menu_Not_Empty);
		refresh();
	}
	else if(isset($delete)) {
		notice('info',Category_Deleted);
		refresh();
	}
	else {
		notice('error',Please_Select_Category);
		refresh();
	}
	
}
		