<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
/***********************************************/
/*		  User Constants               */
/***********************************************/
Class User{
    var $id; 
    var $user; 
    var $email; 
    var $name;
    public static $token;
    public static $level; 
    public static $logged_id = false;
    
    function __construct($uid = null) {
        if (!empty($uid)) {
            $this->id = $uid;
        }
        echo 1;
    }    
    
    static function register() {
        return $this->logged_id;
    }
    
    static function login($user, $password) {		
		$sql = DB::table(FDBPrefix."user")
		->where("status=1 AND user='".$user."' 
			AND password='".MD5($password)."'")
		->get();
		
		if($sql)
		$qr = $sql[0];

		if(isset($qr)) {
            self::$token= sha1(md5(time().$qr['user']));
            
			$_SESSION['USER_ID']  	= $qr['id'];
			$_SESSION['USER'] 		= $qr['user'];
			$_SESSION['USER_NAME']	= $qr['name'];
			$_SESSION['USER_EMAIL']	= $qr['email'];
			$_SESSION['USER_LEVEL'] = $qr['level'];
			$_SESSION['USER_LOG'] 	= $qr['time_log'];	
			$_SESSION['USER_TOKEN'] = self::$token ;
			
			$time_log = date('Y-m-d H:i:s');
			Database::table(FDBPrefix.'user')
			->where('id='.$qr['id'])
			->update(["time_log"=>"$time_log"]); 
			
			Database::table(FDBPrefix."session_login")
			->delete('user_id='.$qr['id']);
			
			$qr = Database::table(FDBPrefix."session_login")->
			insert([$qr['id'],$qr['user'],$qr['level'],date('Y-m-d H:i:s'), self::$token]);
		}	
		
		if(!empty($_SESSION['USER_ID']) AND userInfo()){
			self::$logged_id = true;
			return true;
		}
		else {
			return false;	
		}
    }
     

    static function logged_in() {
		if(USER_ID)
            return true;
        else
            return false;
    } 
    
    static function logout() {
        $qr = Database::table(FDBPrefix."session_login")->
		delete("token = '". $_SESSION['USER_TOKEN'] ."'");
        $_SESSION['USER_LEVEL']  = 99;
        $_SESSION['USER']  = null;
        $_SESSION['USER_ID']  = null;
        $_SESSION['USER_NAME']  = null;
        $_SESSION['USER_EMAIL']  = null;
		$_SESSION['USER_LOG'] 	= null;	
		$_SESSION['USER_TOKEN']	= null;
		User::$logged_id = false;
    }
    
    static function activation($code) {
        if (!empty($code)) {
            self::$logged_id = true;
        }
    }
    static function forgot($email) {
        if (!empty($email)) {
            self::$logged_id = true;
        }
    }
        
    static function reset($code) {
        if (!empty($code)) {
            self::$logged_id = true;
        }
    } 
  
    static function info($id = null) {
		if(empty($id)) $id = USER_ID;
		$user = Database::table(FDBPrefix.'user')->where("id = $id")->get();
		return (object)$user[0];
    } 	
	
    static function get() {
		if(empty($id)) $id = USER_ID;
		$user = Database::table(FDBPrefix.'user')->where("id = $id")->get();
		return (object)$user[0];
    } 	
   
}

if(empty($_SESSION['USER_LEVEL']) or $_SESSION['USER_LEVEL'] == 0 or $_SESSION['USER_LEVEL'] == 99) {
	$_SESSION['USER_LEVEL']  = 99;
	$_SESSION['USER']  = null;
	$_SESSION['USER_ID']  = null;
	$_SESSION['USER_NAME']  = null;
	$_SESSION['USER_EMAIL']  = null;
}

// user defined
define('USER', $_SESSION['USER']); 
define('USER_ID', $_SESSION['USER_ID']);
define('USER_NAME', $_SESSION['USER_NAME']);
define('USER_LEVEL',$_SESSION['USER_LEVEL']);
define('USER_EMAIL', $_SESSION['USER_EMAIL']);
if(isset($_SESSION['USER_TOKEN']))
define('USER_TOKEN', $_SESSION['USER_TOKEN']);
else
define('USER_TOKEN', 'null');

// Quick sql access level
define('Level_Access',"AND level >= ".USER_LEVEL);
define('SQL_USER_LEVEL',"level >= ".USER_LEVEL);


