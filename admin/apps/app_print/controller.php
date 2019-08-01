<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

require_once('model/query.php');
require_once('model/funct.php');

$db = new FQuery();  		

/****************************************/
/*		  Delete Article Category 		*/
/****************************************/
if(isset($_POST['check_category'])){
	$source = @$_POST['check_category'];
	$source = multipleSelect($source);
	$delete = multipleDelete('article_category',$source,'article');
	if($delete == 'noempty') {
		notice('error',Category_Not_Empty);
		redirect(getUrl());
	}
	else if(isset($delete)) {
		notice('info',Category_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Please_Select_Category);
		redirect(getUrl());
	}
}
	


/****************************************/
/*		   Add Tag		*/
/****************************************/
if(isset($_POST['add_tag']) or isset($_POST['save_tag'])){
        $t = striptags($_POST['name']);
	if(!empty($t)) {            
		$qr=$db->insert(FDBPrefix.'article_tags',array("",striptags($_POST['name']),striptags($_POST['desc']),"")); 		
		if($qr AND isset($_POST['save_tag'])){		
			notice('success',Tag_Added);	
			redirect('?app=article&view=tag');
		}
		else if($qr){ 
			$sql2 = $db->select(FDBPrefix.'article_tags','*','','id DESC'); 
			$qrs = $sql2[0];
			notice('success',Tag_Added);
			redirect("?app=article&view=tag&act=edit&id=$qrs[id]");
		}
		else {			
			notice('error',Tag_Exists,2);
		}					
	}
	else {				
		notice('error',Status_Invalid,2);
	}
}

/****************************************/
/*		      Delete Tag				*/
/****************************************/ 	
if(isset($_POST['delete_tag']) or isset($_POST['check_tag'])){
	$source = @$_POST['check_tag'];
	$source = multipleSelect($source);
	$delete = multipleDelete('article_tags',$source);	
	if(isset($delete)){
		notice('info',Tag_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Please_Select_Item);
		redirect(getUrl());
	}
}	


/****************************************/
/*		      Delete Comment			*/
/****************************************/ 	
if(isset($_POST['delete_comment']) or isset($_POST['check_comment'])){
	$source = @$_POST['check_comment'];
	$source = multipleSelect($source);
	$delete = multipleDelete('comment',$source);	
	if(isset($delete)){
		notice('info',Comment_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Please_Select_Item);
		redirect(getUrl());
	}
}

	
//Add new data
if(Input::post('save')) {	
	$data 	= Input::$post;
	if(Query::add($data)) 
		redirect('?app='.$app['root'].'&act=edit&id='.DB::$last_id);	
}

if(Input::post('save_quit')) {	
	$data 	= Input::$post;
	if(Query::add($data)) redirect('?app='.$app['root']);	
}

if(Input::post('save_new')) {	
	$data 	= Input::$post;
	if(Query::add($data)) 
		redirect('?app='.$app['root'].'&act=add');		
}

if(Input::post('save_category')) {	
	$data 	= Input::$post;
	if(Query::add_category($data)) 
		redirect('?app='.$app['root'].'&act=edit&view=category&id='.DB::$last_id);	
}

if(Input::post('add_category')) {	
	$data 	= Input::$post;
	if(Query::add_category($data)) 
		redirect('?app='.$app['root'].'&view=category');			
}

if(Input::post('apply_category')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update_category($data, $id)) 
		refresh();
}

if(Input::post('edit_category')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update_category($data, $id)) 
		redirect('?app='.$app['root'].'&view=category');			
}


//Update data
if(Input::post('edit')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update($data, $id)) refresh();	
}

if(Input::post('edit_quit')) {	
	$data 	= Input::$post;	
	$id 	= Input::get('id');
	if(Query::update($data, $id))  redirect('?app='.$app['root']);	
}

if(Input::post('edit_new')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update($data, $id))
		redirect('?app='.$app['root'].'&act=add');		
}

//Delete Data
if(Input::post('delete_confirm')) {	
	$source = Input::post('check');
	$source = multipleSelect($source);
	$delete = multipleDeletes($app['table'], $source);

	if($delete  == 'deleted') {			
		notice('info', Status_Deleted);
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
		$row = Database::table($app['table'])->where("$app[index] = $id")->get(); 
		$jml=count($row);
		if($jml <= 0) {
			notice('info','Sorry, data refference not found');
			redirect("?app=$app[root]");
		}
	}
}


//Update data
if(Input::post('add_kop')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::add_kop($data, $id)) 
		redirect('?app='.$app['root'].'&act=edit&view=kop&id='.DB::$last_id);	
}


//Update data
if(Input::post('edit_kop')) {	
	$data 	= Input::$post;
	$id 	= Input::get('id');
	if(Query::update_kop($data, $id)) refresh();	
}



//Delete Data Template
if(Input::post('check')) {	
	$source = Input::post('check');
	$source = multipleSelect($source);
	$delete = multipleDeletes(FDBPrefix."reports_page", $source, null, "page_id");
}

//Delete Data Kop
if(Input::post('check_kop')) {	
	$source = Input::post('check_kop');
	$source = multipleSelect($source);
	$delete = multipleDeletes(FDBPrefix."reports_kop", $source, null, "kop_id");
}

//Delete Data Kategori
if(Input::post('check_category')) {	
	$source = Input::post('check_category');
	$source = multipleSelect($source);
	$delete = multipleDeletes(FDBPrefix."reports_category", $source, null, "cat_id");
}

if(isset($delete)) {
	if($delete  == 'deleted') {			
		notice('info', Status_Deleted);
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



