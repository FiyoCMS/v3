
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
	
	public function add($data) {	
		//get
		$data = array_query($data,[
			'judul','tanggal','lokasi','deskripsi'
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'judul' => 'required',
		]);
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'test')->insert($data)) {
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
	
	public function update($data, $id) {	
		//get
		$data = array_query($data,[
			'judul','tanggal','lokasi','deskripsi'
			]);
			
		//validation
		$valid = Validator::is_valid($data, [
			'judul' => 'required',
		]); 
		
		//query		
		if($valid === true) {
			if(Database::table(FDBPrefix.'test')->where("id=$id")->update($data)){
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
	
	public function delete($id) {
		if(Database::table('supplier')->delete("id_sup = $id")) {
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
