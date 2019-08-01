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
			
		$author = htmlentities($_POST['author']);	
		$time = date("H:i:s");	
		
				
		$article = htmlentities(Input::post('editor', false));
		$article = str_replace('"',"'",Input::post('text', false));

		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		
		if(Input::post('author_id')) $aid = $_SESSION['USER_ID']; else $aid = Input::post('author_id');

		$data = array_query($data,[
			'category', 'title'  , 'author' => htmlentities($_POST['author']), 'author_id', 'date', 'status', 'level', 'layout',
			'tags' => json_encode(Input::post('tags')), 
			'keyword' => htmlentities($_POST['keyword']) , 'description' =>
		htmlentities($_POST['desc']), 'article' => $article,'editor','parameter' => $param]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'title' => 'required',
			'article' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'article')->insert($data)) {
				self::$message = Article_Saved;	
				notice('success', Article_Saved);	
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
		$author = htmlentities($_POST['author']);	
		$time = date("H:i:s");	
		
		$article = str_replace('"',"'",Input::post('text', false));
		$tags = implode(",",Input::post('tags', false));

		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		
		if(Input::post('author_id')) $aid = $_SESSION['USER_ID']; else $aid = Input::post('author_id');

		$data = array_query($data,[
			'category', 'title'  , 'author' => htmlentities($_POST['author']), 'author_id', 'date', 'status', 'level', 'featured','layout',
			'tags' => $tags, 
			'keyword' => htmlentities($_POST['keyword']) , 'description' =>
		htmlentities($_POST['desc']), 'article' => $article,'editor','parameter' => $param]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'title' => 'required',
			'article' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'article')->where("id=$id")->update($data)){
				self::$message = Article_Saved;	
				notice('success', Article_Saved);	
				return true;
			}
			else {
				self::$message = Status_Fail;
				notice('error',DB::$query);
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
		$data = array_query($data,['name','parent_id','description' ,'keywords','level']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'article_category')->insert($data)) {
				self::$message = Article_Saved;	
				notice('success', Article_Saved);	
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
		$data = array_query($data,['name','parent_id','description' ,'keywords','level']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'article_category')->where("id=$id")->update($data)) {
				self::$message = Article_Category_Saved;	
				notice('success', Article_Category_Saved);	
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

	function comment_update($data, $id) {
			$data = array_query($data,['comment','name','website' ,'email','status']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'email' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'comment')->where("id=$id")->update($data)) {
				self::$message = Comment_Updated;	
				notice('success', Comment_Updated);	
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

	
	function tag_add($data) {
			$data = array_query($data,['description','name']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'article_tags')->insert($data)) {
				self::$message = Tag_Saved;	
				notice('success', Tag_Saved);	
				return true;
			}
			else {
				self::$message = Tag_Exists;
				notice('error',Tag_Exists);				
				return false;
			}
			
		}	
		else {	
			self::$message = $valid; 			
			notice('error', $valid);		
			return false;
		}
	}

	function tag_edit($data, $id) {
			$data = array_query($data,['description','name']);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'article_tags')->where("id=$id")->update($data)) {
				self::$message = Tag_Saved;	
				notice('success', Tag_Saved);	
				return true;
			}
			else {
				self::$message = Tag_Exists;
				notice('error',Tag_Exists);				
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
