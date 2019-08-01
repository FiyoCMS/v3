<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

class Query {
	public static $message = null;
	protected static $status = false;
	
	public static function add($data) {		
		$param ='';
		$tparam = Input::post('totalParam');
		$prm = [];
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++) {
				$prm[Input::post('nameParam'.$p)] = Input::post('param'.$p);
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
			}
			
		$time = date("H:i:s");	
		
				
		$article = htmlentities(Input::post('editor', false));
		$article = str_replace('"',"'",Input::post('text', false));
		$pages = implode(",",Input::post('pages', false));

		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		
		$data = array_query($data,[
			'category', 'title'  ,  'uid', 'kop', 'cover', 'level', 'footer', 'name','file_reff','pages' => $pages,
			'main' => $article,'parameter' => $param]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'title' => 'required',
			'main' => 'required',
			'name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'print_page')->insert($data)) {
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
		$prm = [];
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++) {
				$prm[Input::post('nameParam'.$p)] = Input::post('param'.$p);
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
			}
		$time = date("H:i:s");	
		
		$article = str_replace('"',"'",Input::post('text', false));

		$pages = implode(",",Input::post('pages'));

		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		
		if(Input::post('author_id')) $aid = $_SESSION['USER_ID']; else $aid = Input::post('author_id');

		$data = array_query($data,[
			'category', 'title'  ,  'uid', 'kop', 'cover', 'level', 'footer', 'name', 'file_reff', 'pages' => $pages,
			'main' => $article,'parameter' => $param]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'title' => 'required',
			'main' => 'required',
			'name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'print_page')->where("page_id=$id")->update($data)){
				self::$message = Status_Saved;	
				notice('success', Status_Saved);	
				return true;
			}
			else {
				self::$message = Status_Fail;
				notice('error', 'Nama unik sudah digunakan!');
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
		if(Database::table('print_page')->delete("id = $id")) {
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
		$data = array_query($data,['cat_name','description' ,'level']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'cat_name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'print_category')->insert($data)) {
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

	
	public static function update_category($data, $id) {	
		$data = array_query($data,['cat_name','description' ,'level']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'cat_name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'print_category')->where("cat_id=$id")->update($data)) {
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

	public static function update_kop($data, $id) {
		//parameter
		$param ='';
		$tparam = Input::post('totalParam');
		$prm = [];
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++) {
				$prm[Input::post('nameParam'.$p)] = Input::post('param'.$p);
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
			}
		
		$article = str_replace('"',"'",Input::post('text', false));

		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		$data = array_query($data,[
			'name', 'line',
			'text' => $article,'parameter' => $param]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'text' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'print_kop')->where("kop_id=$id")->update($data)){
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

	public static function add_kop($data) {
		//parameter
		$param ='';
		$tparam = Input::post('totalParam');
		$prm = [];
		if(Input::post('totalParam'))
			for($p=1;$p<=$tparam;$p++) {
				$prm[Input::post('nameParam'.$p)] = Input::post('param'.$p);
				$param=$param.Input::post('nameParam'.$p)."=".Input::post('param'.$p).';\n';
			}
		
		$article = str_replace('"',"'",Input::post('text', false));

		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		
		$data = array_query($data,[
			'name', 'line',
			'text' => $article,'parameter' => $param]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'text' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'print_kop')->insert($data)){
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
	
}
