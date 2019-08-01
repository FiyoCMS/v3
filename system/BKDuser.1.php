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
Class UserPNS {
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
    }    
    
    static function register() {
        return $this->logged_id;
    }
    

    static function login($user, $password) {		
		
    }
     
    
    static function loginPNS($nip, $password) {
		//login to EPS2017
        DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
		$sql = DB::table("USER_NEW")
		->where("username='".$nip."' AND password='".MD5($password)."'")
        ->get();
		//$sql = DB::select("SELECT u.* FROM USER_NEW u,MASTFIP08 m WHERE username='".$nip."' AND PASSWORD=MD5('".$password."') AND u.nip=m.B_02B AND B_02B NOT IN (SELECT B_02B FROM MASTFIP08 WHERE A_01='D0' AND A_02<>'00' AND A_04>'30')");
        $level = 0;
		if($sql) {
			$user = $sql[0];
			$level = explode(",",$user['role']);
			$level = min($level);

		}
        
		if(isset($user)) {
            $sql = DB::table('MASTFIP08')
			->where("B_02B = '".$user['nip']."'")->get();
			if($sql)
				$qr = $sql[0];
        }


		if(isset($qr)) {			
			$skpd = '';
			


			$sk = DB::query("SELECT u.*,t.nm skpd, t.kd kdskpd,l.NALOK satker,m.B_02B FROM 
				USER_NEW u,
				MASTFIP08 m,
				TABLOK08 t,
				TABLOKB08 l
			WHERE u.nip=m.B_02B AND m.A_01=t.kd AND
			m.A_01=l.A_01 AND m.A_02=l.A_02 AND m.A_03=l.A_03 AND m.A_04=l.A_04 AND l.A_05='00'
			AND u.username='$nip'", true, true);


            $nama =  $qr['B_03'];
			$email =  $qr['B_EMAIL'];
						
			$level = explode(",",$user['role']);
			$level = min($level);
			if($level < 3)  {
				if($nip == '198809022011011004') 
					$level = 2;
				else if($level < 3) 
					$level = 3;
			}

			$_SESSION['USER_ID']  	= $user['id'];
			$_SESSION['USER'] 		= $user['username'];
			$_SESSION['USER_NIP'] 	= $sk[0]['B_02B'];
			$_SESSION['USER_SKPD'] 	= $sk[0]['skpd'];
			$_SESSION['USER_KODE_SKPD'] = $sk[0]['kdskpd'];
			$_SESSION['USER_SATKER'] 	= $sk[0]['satker'];
			$_SESSION['USER_UNIT_KERJA'] 	= $sk[0]['satker'];
			$_SESSION['USER_SUB_UNIT'] 	= '';
			$_SESSION['USER_NAME']	= $nama;
			$_SESSION['USER_EMAIL']	= $email;
			$_SESSION['USER_LEVEL'] = $level;
			$_SESSION['USER_ROLE']  = $user['role'];
			$_SESSION['USER_LOG'] 	= date("Y-m-d H:i:s");	
			self::$token= sha1(md5(time().$user['username']));	

			$_SESSION['USER_TOKEN'] = self::$token ;

			
			$_SESSION['USER_ID']  	= $qr['id'];
			$_SESSION['USER']['DATA']  	= $sk[0];	
			$time_log = date('Y-m-d H:i:s');
			
            DB::reConnect();
			Database::table(FDBPrefix."session_login")
			->delete('user_id='.$user['id']);
			
			$qr = Database::table(FDBPrefix."session_login")->
            insert([$user['id'],$user['username'],$level, date('Y-m-d H:i:s'), self::$token]);
		} else if($level == 1) {
			$nama =  $user['username'];
			$email = 'firstryan@gmail.com';		

			$_SESSION['USER_ID']  	= $user['id'];
			$_SESSION['USER'] 		= $user['username'];
			$_SESSION['USER_NIP'] 	= $user['nip'];
			$_SESSION['USER_SKPD'] 	= '';
			$_SESSION['USER_NAME']	= $nama;
			$_SESSION['USER_EMAIL']	= $email;
			$_SESSION['USER_LEVEL'] = $level;
			$_SESSION['USER_ROLE']  = $user['role'];
			$_SESSION['USER_LOG'] 	= date("Y-m-d H:i:s");	
			self::$token= sha1(md5(time().$user['username']));	

			$_SESSION['USER_TOKEN'] = self::$token ;
			
			$time_log = date('Y-m-d H:i:s');
			
            DB::reConnect();
			Database::table(FDBPrefix."session_login")
			->delete('user_id='.$user['id']);			
			$qr = Database::table(FDBPrefix."session_login")->
            insert([$user['id'],$user['username'],$level, date('Y-m-d H:i:s'), self::$token]);
			
		}
		
		DB::reConnect();
		if(!empty($_SESSION['USER_ID']) AND userInfo()){
			User::$logged_id = true;
			return true;
		}
		else {
			return false;	
		}
    }

    static function logged_id() {
        return $this->logged_id;
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
        
		$_SESSION['USER_NIP']	= null;
		$_SESSION['USER_SKPD']	= null;
		$_SESSION['USER_SATKER']  = null;
		User::$logged_id = false;
    }
    
    static function activation($code) {
        if (!empty($code)) {
            $this->logged_id = true;
        }
    }
    static function forgot($email) {
        if (!empty($email)) {
            $this->logged_id = true;
        }
    }
        
    static function reset($code) {
        if (!empty($code)) {
            $this->logged_id = true;
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
	$_SESSION['USER_SKPD']  = null;
	$_SESSION['USER_SATKER']  = null;
	$_SESSION['USER_NIP']  = null;
}

// user defined
if(!defined('USER'))
define('USER', $_SESSION['USER']); 

if(!defined('USER_ID'))
define('USER_ID', $_SESSION['USER_ID']);

if(!defined('USER_NAME'))
define('USER_NAME', $_SESSION['USER_NAME']);

if(!defined('USER_LEVEL'))
define('USER_LEVEL',$_SESSION['USER_LEVEL']);

if(!defined('USER_EMAIL'))
define('USER_EMAIL', $_SESSION['USER_EMAIL']);

if(!defined('USER_NIP'))
	define('USER_NIP', $_SESSION['USER_NIP']);
else 
	define('USER_NIP', USER_ID);


if(isset($_SESSION['USER_SKPD']))
define('USER_SKPD', $_SESSION['USER_SKPD']);

if(isset($_SESSION['USER_SATKER']))
define('USER_SATKER', $_SESSION['USER_SATKER']);

if(!defined('USER_TOKEN')) {
	if(isset($_SESSION['USER_TOKEN']))
		define('USER_TOKEN', $_SESSION['USER_TOKEN']);
	else
		define('USER_TOKEN', 'null');	
}
// Quick sql access level
if(!defined('Level_Access'))
define('Level_Access',"AND level >= ".USER_LEVEL);

if(!defined('SQL_USER_LEVEL'))
define('SQL_USER_LEVEL',"level >= ".USER_LEVEL);
