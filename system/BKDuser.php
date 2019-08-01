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
    public static $logged_in = false;
    
    function __construct($uid = null) {
        if (!empty($uid)) {
            self::$id = $uid;
        }
    }    
    
    static function register() {
        return self::$logged_in;
    }
    
    static function login($nip, $password, $pass = false) {
		//login to EPS2017
        DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
		
		if(!$pass) {
			$sql = DB::table("USER_NEW")
			->where("username='".$nip."' AND password='".MD5($password)."'")
			->get();
		}
		else {
			$sql = DB::table("USER_NEW")
			->where("username='$nip'")
			->get();
		}
		
		if($sql) $user = $sql[0];
        
		if(isset($user)) {
            $sql = DB::table('MASTFIP08')
			->where("B_02B = '".$user['nip']."'")->get();
			if($sql)
				$qr = $sql[0];
        }


		if(isset($qr)) {
			$peg = DB::table('MASTFIP08')->select("*, TABLOK08.nm skpd, 
					tbtktdik.nm as pend, 
					TABLOKB08.NALOK satker, 
					TABLOK08.kd kdskpd ")
				->where("B_02B = '$nip'")
				->leftJoin("TABLOKB08","TABLOKB08.A_01=MASTFIP08.A_01 AND
					TABLOKB08.A_02=MASTFIP08.A_02 AND
					TABLOKB08.A_03=MASTFIP08.A_03 AND
					TABLOKB08.A_04=MASTFIP08.A_04 AND
					TABLOKB08.A_05=MASTFIP08.A_05")
				->leftJoin("tbtktdik","H_1A=id")
				->leftJoin("TABLOK08","kd=MASTFIP08.A_01")
				->limit(1)->get();
				

            $nama =  $qr['B_03'];
			$email =  $qr['B_EMAIL'];
			
			$level = explode(",",$user['role']);
			$level = min($level);
			$level = 88;		

			self::$token= sha1(md5(time().$user['username']));	
			$time_log = date('Y-m-d H:i:s');
			
			// Setup SINAGA DATA
			$data = [];			
			if(isset($peg[0]['B_02B'])) {
				$data['nama'] = $peg[0]['B_03'];
				$data['nip'] = $peg[0]['B_02B'];
				$data['tgl_lahir'] = $peg[0]['B_05'];
				$data['tmp_lahir'] = $peg[0]['B_04'];
				$data['golongan'] = $peg[0]['F_03'];
				$data['tmt'] = $peg[0]['F_TMT'];
				$data['pendidikan'] = $peg[0]['pend'];
				$data['jabatan'] = $peg[0]['I_JB'];
				$data['unit'] = $peg[0]['satker'];
				$data['instansi'] =  $peg[0]['nm'];

				//set SKPD
				if(isset($peg[0]['skpd']))
				$data['skpd'] =  $peg[0]['skpd'];

				//jenis jabatan 0 = JFU , 2 = JFT, 1 = struktural
				$jenis_jabatan = $peg[0]['I_5A'];
				if($jenis_jabatan == 1) 
					$data['jenis_jabatan'] = 'JFU';
				else if($jenis_jabatan == 2) 
					$data['jenis_jabatan'] = 'JFT';
				else
					$data['jenis_jabatan'] = 'Struktural';

				$kdsubunitkerja = $peg[0]['KOLOK'];
				$data['kode_sub_unit'] = $peg[0]['KOLOK'];	
				$data['raw'] = $peg[0];
			}		
				
			$_SESSION['USER_DATA']	= $data;	


            DB::reConnect();
			Database::table(FDBPrefix."session_login")
			->delete('user_id='.$user['id']);

			if($level == 1) {
				$nama =  $user['username'];
				$email = 'firstryan@gmail.com';		
			}
			
			$_SESSION['USER_ID']  	= $user['id'];
			$_SESSION['USER'] 		= $user['username'];
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
			
			self::$logged_in = true;
			return true;
		}
		else {
			return false;	
		}
    }

    static function logged_in() {
		if(isset(json_decode(USER_DATA)->nip)) {			
			self::$logged_in = true;
			return true;	
		}
		else
			return false;	
    } 
    
    static function logout() {
        $qr = DB::table(FDBPrefix."session_login")->
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
		$_SESSION['USER_DATA']  = null;
		self::$logged_in = false;

		return true;
    }
    
    static function activation($code) {
        if (!empty($code)) {
			self::$logged_in = true;
        }
    }
    static function forgot($email) {
        if (!empty($email)) {
			self::$logged_in = true;
        }
    }
        
    static function reset($code) {
        if (!empty($code)) {
			self::$logged_in = true;
        }
    } 
  
    static function info($nip = null) {
		if(!$nip) $nip = USER_ID;
        DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
		$peg = DB::table('MASTFIP08')->select("*, 
			TABLOK08.nm skpd, 
			tbtktdik.nm as pend, 
			TABLOKB08.NALOK satker, 
			TABLOK08.kd kdskpd ")
		->where("B_02B = '$nip'")
		->leftJoin("TABLOKB08","TABLOKB08.A_01=MASTFIP08.A_01 AND
			TABLOKB08.A_02=MASTFIP08.A_02 AND
			TABLOKB08.A_03=MASTFIP08.A_03 AND
			TABLOKB08.A_04=MASTFIP08.A_04 AND
			TABLOKB08.A_05=MASTFIP08.A_05")
		->leftJoin("tbtktdik","H_1A=id")
		->leftJoin("TABLOK08","kd=MASTFIP08.A_01")
		->limit(1)->get();

		// Setup SINAGA DATA
		$data = [];			
		if(isset($peg[0]['B_02B'])) {
			$data['nama'] = $peg[0]['B_03'];
			$data['nip'] = $peg[0]['B_02B'];
			$data['tgl_lahir'] = $peg[0]['B_05'];
			$data['tmp_lahir'] = $peg[0]['B_04'];
			$data['golongan'] = $peg[0]['F_03'];
			$data['tmt'] = $peg[0]['F_TMT'];
			$data['pendidikan'] = $peg[0]['pend'];
			$data['jabatan'] = $peg[0]['I_JB'];
			$data['unit'] = $peg[0]['satker'];
			$data['instansi'] =  $peg[0]['nm'];

			//jenis jabatan 0 = JFU , 2 = JFT, 1 = struktural
			$jenis_jabatan = $peg[0]['I_5A'];
			if($jenis_jabatan == 1) 
				$data['jenis_jabatan'] = 'JFU';
			else if($jenis_jabatan == 2) 
				$data['jenis_jabatan'] = 'JFT';
			else
				$data['jenis_jabatan'] = 'Struktural';

			$kdsubunitkerja = $peg[0]['KOLOK'];
			$data['kode_sub_unit'] = $peg[0]['KOLOK'];	
			$data['raw'] = $peg[0];
		}
		
		return (object)$data;
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
	$_SESSION['USER_DATA']  = null;
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

if(!defined('USER_DATA'))
define('USER_DATA', json_encode(session('USER_DATA')));

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
