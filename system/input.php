<?php
/** 
 * Adds a custom validation rule using a callback function.
 * @version	2.5 / 3.0
 * @package	Fiyo CMS
 * @copyright	Copyright (C) 2016 Fiyo CMS.
 * @license	GNU/GPL, see LICENSE.
 */

include_once 'libs/gump.class.php';

class Input extends GUMP {
    
    public static $req;
    public static $post;
    public static $get;
    public static $request;
    public static $session;

    private static $file;
    private static $_instance = null;
	
	
	public function __construct( ){		
        self::$post = @$_POST;	
        self::$get = @$_GET;	
        self::$session = @$_SESSION;	
	}
    static public function get($var,$strip = true) { 
        if(isset($_GET[$var]))   {
            $get = $_GET[$var];
            if(is_array($get) or is_object($get))
                return $get;
            else if ($strip !== true AND $strip !== false) {  
                return strip($get, ENT_QUOTES);
            }
            else if ($strip === true) {
                return strip_tags($get);
            } else {
                return $get;
            }
        }
        else 
            return false;
    }  
   
    
    static public function post($var, $strip = true) {
        if(isset($_POST[$var]))   {
            $post = $_POST[$var];
             if(is_array($post) or is_object($post))
                return $post;
            else if ($strip !== true AND $strip !== false) {   
                return strip($post, ENT_QUOTES);
            }
            else if($strip) 
                return strip_tags($post);
            else {
                return $post;

            }
                
        }
        else 
            return false;
    }

    static public function request($var, $strip = true) {
        if(isset($_REQUEST[$var]))   {
            $request = $_REQUEST[$var];
             if(is_array($request) or is_object($request))
                return $request;
            else if ($strip !== true AND $strip !== false) {   
                return strip($request, ENT_QUOTES);
            }
            else if($strip) 
                return strip_tags($request);
            else {
                return $request;

            }
                
        }
        else 
            return false;
    }
	
    static public function session($var, $strip = true) {
        if(isset($_SESSION[$var]))   {
            $sess = $_SESSION[$var];
            if(is_array($sess) or is_object($sess))
                return $sess;
            else if ($strip !== true AND $strip !== false) {      
                return strip($sess, ENT_QUOTES);
            }
            else if($strip)
                return strip_tags ($sess);
            else 
                return $sess;
        }
        else 
            return false;
    }

    static public function setSession($var, $value) {
        $_SESSION[$var] = $value;;
    }
	
    static public function server($var, $strip = true) {
        if(isset($_SERVER[$var]))   {
            $server = $_SERVER[$var];
            if(is_array($server) or is_object($server))
                return $server;
            else if ($strip !== true AND $strip !== false) {      
                return strip($sess, ENT_QUOTES);
            }
            if($strip)
                return strip_tags($server);
            else 
                return $server;
        }
        else 
            return false;
    }
	
	static public function all() {		
        return array_merge($_POST, $_GET);	
    }  
	
	public static function file($var) {
		
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
		
        if(isset($_FILES[$var]) AND $_FILES[$var]['error'] == UPLOAD_ERR_OK)   {
            $post = $_FILES[$var];
            $post = array_merge($post, ['extention' => pathinfo($post['name'], PATHINFO_EXTENSION)]);
			self::$file = $post;
			return self::$file;
        }
        else 
            return false;
    }

    public static function files($var) {
		
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
			self::$file = $_FILES[$var];
			return self::$_instance;
    }
   
    public function move($destination, $filename, $overwrite = false) {
		$file = self::$file;
		if ($file['error'] == UPLOAD_ERR_OK) {
			$tmp	= $file["tmp_name"];
			$name	= basename($file["name"]);
			$name = str_replace('{{$filename}}',$name, $filename); 
			if($overwrite AND is_bool($overwrite)) {
				
				@unlink("$destination/$name");
			}
			else if($overwrite) {
				@unlink("$destination/$overwrite");
			} 
			move_uploaded_file($tmp, "$destination/$name");			
			return true;
		}
		else {
			return false;			
		}
    }	
}

class_alias('Input', 'Req');
class_alias('Input', 'Route');
class_alias('GUMP', 'Validator');
new Input();

/*
foreach($_GET as $key => $val) {
        if(isset($_GET[$key])){
            if(stripos($key, "entities") !== false OR stripos($key, "editor") !== false OR stripos($key, "html") !== false)
            $_GET[$key] = htmlentities($_GET[$key], ENT_QUOTES);
        else  if(stripos($key, "unstrip") !== false OR is_array($_GET[$key]))
            $_GET[$key] = $_GET[$key];
        else
            $_GET[$key] = strip_tags($_GET[$key]);
    }
}

foreach($_POST as $key => $val) {
    if(isset($_POST[$key])){
        if(stripos($key, "entities") !== false OR stripos($key, "editor") !== false OR stripos($key, "html") !== false)
            $_POST[$key] = htmlentities($_POST[$key], ENT_QUOTES);
        else  if(stripos($key, "unstrip") !== false OR is_array($_POST[$key]))
            $_POST[$key] = $_POST[$key];
        else
            $_POST[$key] = strip_tags($_POST[$key]);
    }
}*/

