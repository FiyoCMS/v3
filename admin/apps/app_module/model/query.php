<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


class Query {
	public static $message = null;
	protected static $status = false;
	
	public static function add($data) {		
		//parameter
		$param ='';
		$tparam = Input::post('totalParam');
		$prm = [];
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++) {
				$prm[Input::post('nameParam'.$p)] = Input::post('param'.$p);
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
			}
			
		$page = Input::post('page');
		$page = @multipleSelect($page);
				
		$param .= htmlentities(Input::post('editor', false));

		if(checkLocalhost()) {
			$param = str_replace(FLocal."media/","media/",$param);	
			$param = str_replace("http://localhost","",$param);			
		}
		$data = array_query($data,[
			'folder', 'name', 'position', 'short', 'page' => $page, 'level', 'class', 'style', 
			'parameter' => $param, 'status','show_title']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'position' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'module')->insert($data)) {
				self::$message = Status_Saved;	
				return true;
			}
			else {
				echo DB::$query;
				self::$message = Status_Fail;	
				return false;
			}
			
		}	
		else {		
			self::$message = $valid; 			
			notice('error', $valid);		
			return false;
		}
	}
	
	public static function update($data, $id) {
		//parameter

		$param ='';
		$prm = [];
		if( $data['totalParam']) {
			$tparam = $post['totalParam'];
			for($p=1;$p<=$tparam;$p++) {
				$prm[Input::post('nameParam'.$p)] = Input::post('param'.$p);
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
			}
		}
			
		$page = $data['page'];
		$page = multipleSelect($page);

		$param .=  htmlspecialchars($data['editor'], ENT_QUOTES);		

		if(checkLocalhost()) {
			$param = str_replace(FLocal."media/","media/",$param);	
			$param = str_replace("http://localhost","",$param);			
		}

		
		$data = array_query($data,[
			'folder', 'name', 'position', 'short', 'page' => $page, 'level', 'class', 'style', 
			'parameter' => "$param", 'status','show_title']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'position' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'module')->where("id=$id")->update($data)){
				self::$message = Status_Saved;		
				return true;
			}
			else {
				self::$message = Status_Fail;			
				return false;
			}
			
		}	
		else {		
			self::$message = $valid; 			
			notice('error', $valid);		
			return false;
		}
	}
	
	public static function delete($id) {
		if(Database::table('permasalahan')->delete("id = $id")) {
				self::$message = Status_Deleted;	
				notice('info', Status_Deleted);	
				return true;
		}
		else {
			notice('error',Status_Fail);				
			return false;
		}
	}
}


/****************************************/
/*			 Add Category Menu			*/
/****************************************/
if(isset($_POST['add_category']) or isset($_POST['save_category'])){		
	$db = new FQuery();  
	$db->connect();				
	if(!empty($_POST['title']) AND !empty($_POST['cat']) AND !empty($_POST['level'])) {
		$cat=  stripTags(strtolower(str_replace(" ","","$_POST[cat]")));	
		$row=$db->insert(FDBPrefix.'menu_category',array("","$cat","$_POST[title]","$_POST[desc]","$_POST[level]")); 
		if(isset($_POST['add_category']) AND $row ){	
			$sql = $db->select(FDBPrefix.'menu_category','id','','id DESC' ); 	  
			$row = $sql[0];	
			notice('success',Category_Menu_Saved);
			redirect('?app=menu&view=edit_category&id='.$row['id']);
		}		
		else if(isset($_POST['save_category']) AND $row){
			notice('success',Category_Menu_Saved);
			redirect('?app=menu&view=category');
		}
		else {				
			notice('error',Category_Exists,2);
		}					
	}
	else {
		notice('error',Status_Invalid);
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
		
	
/****************************************/
/*			 Edit category menu			*/
/****************************************/
if(isset($_POST['edit_category']) or isset($_POST['apply_category'])){
	$db = new FQuery();  
	$db->connect();
	$cat=stripTags(strtolower(str_replace(" ","","$_POST[cat]")));	
	if(!empty($_POST['title']) AND !empty($_POST['cat'])){
		$row=$db->update(FDBPrefix.'menu_category',array("title"=>"$_POST[title]",
		'category'=>"$cat",
		'level'=>"$_POST[level]",
		'description'=>"$_POST[desc]"),
		'id='.$_POST['id']); 		
		//edit or update catgory name
		$sql =  $db->select(FDBPrefix.'menu'); 	  
		foreach($sql as $s){	
			$rows=$db->update(FDBPrefix.'menu',array("category"=>"$cat"),"category='$_POST[cats]'");
		}					
		if(isset($_POST['edit_category']) AND $row){
			notice('loading');
			notice('success',Category_Menu_Saved);
			redirect('?app=menu&view=category',1);
		}			
		else if(isset($_POST['apply_category']) AND $row){
			notice('success',Category_Menu_Saved);
			redirect(getUrl());
		}
		else {
			notice('error',Status_Fail);
		}
	}
	else {
		notice('error',Status_Invalid);
	}
}



/****************************************/
/*		       Edit Menu				*/
/****************************************/ 		
if(isset($_POST['save_edit']) or isset($_POST['apply_edit'])){		
	if( !empty($_POST['name']) AND 
		!empty($_POST['cat']) AND 
		!empty($_POST['link'])) {
		$param=''; // first value from $param
		if(isset($_POST['totalParam']))
			for($p=1;$p<=$_POST['totalParam'];$p++)
			{
				@$param=$param.$_POST["nameParam$p"]."=".$_POST['param'.$p].';\n';
			}
			$param = str_replace('"',"'",$param);
		@$parameter = $param;		
		$db = new FQuery();  
		$db->connect();
		$db->select(FDBPrefix.'menu');
		$cat=$_POST['cat'];
		$row=$db->update(FDBPrefix.'menu',array(				
		"category"=>"$_POST[cat]",
		"name"=>stripTags("$_POST[name]"),
		"link"=>"$_POST[link]",
		"app"=>"$_POST[apps]",
		"parent_id"=>"$_POST[parent_id]",
		"status"=>"$_POST[status]",
		"show_title"=>"$_POST[show_title]",
		"level"=>"$_POST[level]",
		"title"=>"$_POST[title]",
		"sub_name"=>"$_POST[sub_name]",
		"class"=>"$_POST[class]",
		"style"=>"$_POST[style]",
		"short"=>"$_POST[short]",
		"layout"=>"$_POST[layout]",
		"parameter"=>"$parameter"),
		"id=$_POST[id]");
		if($row AND isset($_POST['save_edit'])){	
			notice('success',Menu_Updated);
			redirect("?app=menu&cat=$_POST[cat]");
		}
		else if($row AND isset($_POST['apply_edit'])){ 
			notice('success',Menu_Updated);
			redirect(getUrl());
		}
		else {notice('error',Status_Invalid);}					
	}
	else {notice('error',Status_Invalid);}
}
