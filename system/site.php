<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

/********************************************/
/*  		   Site Information	 		 	*/
/********************************************/

/* Define SEF Base URL */
define ('FBase',FUrl());
define ('FUrl','http://'.FBase);

/* SEF Information */
if(plugin_exists('plg_sef')) 
define('SEF_URL', 	siteConfig('sef_url'));
else 
define('SEF_URL', 	false);

define('SEF_EXT', 	siteConfig('sef_ext'));
/* Site Information */
define('SiteUrl', 	siteConfig('site_url'));
define('SiteTitle',	siteConfig('site_title'));
define('SiteName',	siteConfig('site_name'));
define('SiteLang', 	siteConfig('lang'));
define('SiteOnline', siteConfig('site_status'));
define('SiteKeys', siteConfig('site_keys'));
define('SiteDesc', siteConfig('site_desc'));

/* Title Information */
define('TitleType',	siteConfig('title_type'));
define('TitleDiv', 	siteConfig('title_divider'));

//echo SiteOnline;
function link_paging($ext) {	
	$link = $_SERVER['REQUEST_URI']."$ext";
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else $page = 0;
	$link = str_replace("?page=$page","",$link);
	$link = str_replace("&page=$page","",$link);
	return $link;
}

function generateDesc($code) {
	$pagedesc=htmlToText($code);
	$padding = substr($pagedesc, 89);
	if ($padding === 0)
		return $pagedesc; 
	$length = strpos($padding, ".");
	if ($length === 0) 
		return $pagedesc; 
	$pagedesc = str_replace (",", "", $pagedesc);
	$pagedesc = str_replace (")", "", $pagedesc);
	$pagedesc = str_replace ("(", "", $pagedesc);
	$pagedesc = str_replace (".", "", $pagedesc);
	$pagedesc = str_replace ("'", "", $pagedesc);
	$pagedesc = str_replace ('"', "", $pagedesc);
	$pagedesc = str_replace ("\n", "", $pagedesc);
	$pagedesc = str_replace ("&amp;", "", $pagedesc);
	$pagedesc = str_replace ("&gt;", "", $pagedesc);
	$pagedesc = str_replace ("\t", " ", $pagedesc);
	$pagedesc = str_replace ("   ", " ", $pagedesc);
	$pagedesc = str_replace ("  ", " ", $pagedesc);
	$pagedesc = str_replace ("&nbsp;", " ", $pagedesc);
	return substr($pagedesc, 0, $length + 81); 
}

function generateKeywords($text) {
	$parsearray[] = htmlToText($text);
	$parsestring = "z ".strtolower(join($parsearray," "))." y";
	$parsestring = str_replace (",", "", $parsestring);
	$parsestring = str_replace (")", "", $parsestring);
	$parsestring = str_replace ("(", "", $parsestring);
	$parsestring = str_replace (".", "", $parsestring);
	$parsestring = str_replace ("'", "", $parsestring);
	$parsestring = str_replace ('"', "", $parsestring);
	$parsestring = str_replace ("\n", "", $parsestring);
	$parsestring = str_replace ("\t", " ", $parsestring);
	$parsestring = str_replace ("&gt;", " ", $parsestring);
	$parsestring = str_replace ("&amp;", "", $parsestring);
	$parsestring = str_replace ("&nbsp;", " ", $parsestring);

$commonwords = <<<EOF
the a if i you to when of if can while was and it in that with my so at for up on by this from be as me some her she time again were down back would his brother both all one needed not had after there out lot quite many know no but like who your will we is are or our have an more what us which its being anda kita kami jika untuk lalu dari dapat hingga dan itu dalam bahwa dengan saya sehingga jadi di pada untuk oleh ini dari menjadi sebagai bisa melalui akan ingin pilih yang dapatkan tentang menemukan yaitu adalah saya beberapa dia waktu lagi mana kembali atau into ? / - later these : . " ' following \\ such over ensure months
EOF;

	$commonarray = explode(" ",$commonwords);

	for ($i=0; $i<count($commonarray); $i++) {
	   $parsestring = str_replace (" ".$commonarray[$i]." ", " ", $parsestring);
	}
	$parsestring= strip_tags("parsestring");
	$parsestring = str_replace ("  ", " ", $parsestring);
	$parsestring = str_replace ("  ", " ", $parsestring);
	$parsestring = str_replace ("  ", " ", $parsestring);

	$wordsarray = explode(" ",$parsestring);

	for ($i=0; $i<count($wordsarray); $i++) {
	   $word = $wordsarray[$i];
	   if (@$freqarray[$word]) {
		   $freqarray[$word] += 1;
	   } else {
		   $freqarray[$word]=1;
	   }
	}

	@arsort($freqarray);
	$i=0;
	while (list($key, $val) = each($freqarray)) {    
	   $i++;
	   $freqall[$key] = $val;
	   if ($i==15) {
		  break;
	   }
	} 

	for ($i=0; $i<count($wordsarray)-1; $i++) {
	   $j = $i+1;
	   $word2 = $wordsarray[$i]." ".$wordsarray[$j];
	   if (@$freqarray2[$word2]) {
		   $freqarray2[$word2] += 1;
	   } else {
		   $freqarray2[$word2]=1;
	   }
	}

	@arsort($freqarray2);

	$i=0;
	
	if(is_array($freqarray2))
	while (list($key, $val) = each($freqarray2)) {    
	   $i++;
	   $freqall[$key] = $val;
	   if ($i==4) {
		  break;
	   }
	} 

	for ($i=0; $i<count($wordsarray)-2; $i++) {
	   $j = $i+1;
	   $word3 = $wordsarray[$i]." ".$wordsarray[$j]." ".$wordsarray[$j+1];
	   if (@$freqarray3[$word3]) {
		   $freqarray3[$word3] += 1;
	   } else {
		   $freqarray3[$word3]=1;
	   }
	}

	@arsort($freqarray3);

	$i=0;
	if(is_array($freqarray3))
	while (list($key, $val) = each($freqarray3)) {    
	   $i++;
	   $freqall[$key] = $val;
	   if ($i==1) {
		  break;
	   }
	} 

	arsort($freqall);

	$keys = $pagecontents = "";

	while (list($key, $val) = each($freqall)) {    
	   $pagecontents .= "$key => $val<br>";
	   if(strlen($key) > 2)
	   $keys .= "$key, ";
	}
	chop($keys);
	return $keys;
}

/********************************************/
/*  	  		SEF Pagination  			*/
/********************************************/
if(isset($_GET['page']) AND ctype_digit($_GET['page'])) {
	define('_Page',$_GET['page']);	
}
else if(SEF_URL) {
	$p = url_param('page');
	if(ctype_digit($p)) {
		define('_Page',$p);
	} else {
		define('_Page', 0);
	}
}
else {
	define('_Page', 1 );
}

/********************************************/
/*  	  		SEF Pagination  			*/
/********************************************/
if(checkLocalhost()) {
	$flocal = str_replace("http://localhost/","",FUrl);
	define("FLocal",$flocal);
}
else
	define("FLocal","/");
	

/********************************************/
/*  	  Define Page_ID, PageTitle	  		*/
/********************************************/
if(_FINDEX_ != 'BACK') {
	$pid = menuInfo('id',getLink());
	if(isHomePage()) {
		define('Page_ID', homeInfo('id'));
		if(homeInfo('title')) 
			define('PageTitle', homeInfo('title'));
		else
			define('PageTitle', homeInfo('name'));
	}
	else if (!SEF_URL){	
		$link = str_replace("&page="._Page,"",getLink());
		if($pid ==  menuInfo('id') AND !empty($pid)){
			define('Page_ID', $pid);
		}
		else if($pid =  check_permalink('link',$link,'pid'))
			define('Page_ID', $pid);
		else if(app_param('pid') AND is_numeric(app_param('pid'))) 			
			define('Page_ID', pageInfo(app_param('pid'),'id'));
		else
			define('Page_ID',oneQuery('menu','layout'));
	}
	else if (SEF_URL){
		if(!empty($pid) AND $pid ==  menuInfo('id')){
			define('Page_ID', $pid);
		}
		else if(app_param('pid') AND is_numeric(app_param('pid'))) {	
			define('Page_ID', pageInfo(app_param('pid'),'id'));
		}
		else {			
			$pid = check_permalink('permalink',app_param('link'),'pid');
			if($pid == 0) $pid = oneQuery('menu','home',1,'layout');
			
			
			define('Page_ID', $pid);
		}
	}
}


/********************************************/
/*  	  	  Delete Installer  			*/
/********************************************/
if(file_exists('system/installer/index.php'))
	delete_directory('system/installer');
if(file_exists('installer.php'))
	unlink('installer.php');
if(_FINDEX_ == 'BACK' AND file_exists('../system/installer/index.php'))
	delete_directory('../system/installer');


class Site {
    public static $layout = 1;
	public static $theme = 'fiyo'; 
	public static $status = true; 	
    public static $page_id;
    
    function __construct() {

		if(!file_exists("apps/app_". app_param('app')."/")) {
			
			self::$status = false;
		}
		$layout = menuInfo('layout');
		if(empty($layout)) 
			$layout = self::$layout;
		
		$r =  Database::table(FDBPrefix.'theme_layout')
			->select('id')
			->where("id = '".$layout."'")->get();

		if($r) {
			self::$layout = $r[0]['id'];
			return $r[0]['id'];
		} 
		else 
			return false;
    }    
    
    static function setLayout($id) {
        self::$layout = $id;
	}
    
    static function setTheme($folder) {
        self::$theme = $folder;
	}
    static function setStatus($status) {
        self::$status = $status;
	}

    static function setPageID($pid) {
        self::$page_id = $pid;
	}

	static function layout($value) {		
		$layout = menuInfo('layout');
		if(empty($layout)) 
			$layout = self::$layout;
		
		$r =  Database::table(FDBPrefix.'theme_layout')
			->select($value)
			->where("id = '".$layout."'")->get();

		if($r) {
			if($value == 'id')
			self::$layout = $r[0][$value];
			return $r[0][$value];
		} 
		else return false;
	}
}

new Site();