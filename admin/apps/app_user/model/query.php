
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
		
        if(Input::post('password') !== Input::post('kpassword')) {            
				self::$message = Status_Fail;
				notice('error',Status_Fail);			
				return false;
        }
		//get
		$data = array_query($data,[
			'user', 'name', 'email','status','about' => Input::post('bio'),'level', "password"=>MD5("$_POST[password]")
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'user' => 'required',
			'email' => 'required|valid_email',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'user')->insert($data)) {
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
        if(Input::post('password') !== Input::post('kpassword')) {            
			self::$message = Status_Fail;
			notice('error',Status_Fail);			
			return false;
        }
		//get

        if(Input::post('password'))
		    $data = array_query($data,[
			'user', 'name', 'email','status','about' => Input::post('bio'),'level', "password"=>MD5("$_POST[password]")
			]);
        else
		    $data = array_query($data,[
			'user', 'name', 'email','status','about' => Input::post('bio'),'level' 
			]);
			

		//validation
		$valid = Validator::is_valid($data, [
			'name' => 'required',
			'user' => 'required',
			'email' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'user')->where("id=$id")->update($data)){
				self::$message = Status_Saved;	
				notice('success', Status_Saved);	
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
	
	public static function delete($id) {
		if(Database::table('user')->delete("id = $id")) {
				self::$message = Status_Deleted;	
				notice('info', Status_Deleted);	
				return true;
		}
		else {
			notice('error',Status_Fail);				
			return false;
		}
	}

    
    
	public static function add_group($data, $id) {
		    $data = array_query($data,[
			'group_name', 'level','description',
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'group_name' => 'required',
			'level' => 'required',
			'description' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'user_group')->where("id=$id")->insert($data)){
				self::$message = Status_Saved;	
				notice('success', Status_Saved);	
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


	public static function update_group($data, $id) {
		    $data = array_query($data,[
			'group_name', 'level','description',
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'group_name' => 'required',
			'level' => 'required',
			'description' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'user_group')->where("id=$id")->update($data)){
				self::$message = Status_Saved;	
				notice('success', Status_Saved);	
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

    
	public static function delete_group($id) {
		if(Database::table('user_group')->delete("id = $id")) {
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

