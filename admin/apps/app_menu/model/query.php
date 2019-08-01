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
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++)
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
		$param .= str_replace('"',"'",Input::post('editor'));
		
		//get
		$data = array_query($data,[
			'category', 'name', 'link', 'app' => $data['apps'], 'short', 'parent_id', 'level', 'class', 'style', 'parameter' => $param, 'layout' ,'status','show_title','title'
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'category' => 'required',
			'app' => 'required',
			'link' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'menu')->insert($data)) {
				self::$message = Status_Saved;	
				notice('success', Status_Saved);	
				return true;
			}
			else {
				self::$message = Status_Fail;
				notice('error',Status_Fail);				
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
		$tparam = Input::post('totalParam');
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++)
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
		$param .= str_replace('"',"'",Input::post('editor'));
		
		//get
		$data = array_query($data,[
			'category', 'name', 'link', 'app' => $data['apps'], 'short', 'parent_id', 'level', 'class', 'style', 'parameter' => $param, 'layout' ,'status','show_title','title'
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'category' => 'required',
			'app' => 'required',
			'link' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'menu')->where("id=$id")->update($data)){
				self::$message = Status_Saved;	
				notice('success', Status_Saved);	
				return true;
			}
			else {
				self::$message = Status_Fail;
				notice('error',Status_Fail);				
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

	
	public static function add_category($data) {	
		$data = array_query($data,[
			'category', 'description', 'title', 'level'
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'description' => 'required',
			'category' => 'required',
			'title' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'menu_category')->insert($data)) {
				self::$message = Category_Menu_Saved;	
				notice('success', Category_Menu_Saved);	
				return true;
			}
			else {
				self::$message = Status_Fail;
				notice('error',Status_Fail);				
				return false;
			}
			
		}	
		else {		
			self::$message = $valid; 			
			notice('error', $valid);		
			return false;
		}
	}
	
	public static function update_category($data, $id) {
		//get
		$data = array_query($data,[
			'category', 'description', 'title', 'level'
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'description' => 'required',
			'category' => 'required',
			'title' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'menu_category')->where("id=$id")->update($data)){
				self::$message = Category_Menu_Saved;	
				notice('success', Category_Menu_Saved);	
				return true;
			}
			else {
				self::$message = Status_Fail;
				echo DB::$query;
				notice('error',Status_Fail);				
				return false;
			}
			
		}	
		else {		
			self::$message = $valid; 			
			notice('error', $valid);		
			return false;
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
		
	