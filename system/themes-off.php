<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
**/

defined('_OFFSITE_') or die('Access Denied');



/********************************************/
/*         Define Type & Site Title         */
/********************************************/
$themes = FLayout("theme");
if(empty($themes)) $themes = siteConfig('site_theme');
define("FThemeFolder", $themes); 
define("FThemePath",FUrl."themes/".FThemeFolder."");
define("FThemes","themes/".FThemeFolder."/index.php");

$theme = siteConfig('site_theme');
$of_theme = "themes/" .$theme . "/offline.php";
if(file_exists($of_theme))
    require ($of_theme);
else
    require ('offline-theme/index.php');


$output = ob_get_contents();
ob_end_clean();


ob_start();
$output = str_replace(array("href=\"css","href=\"/css"), "href=\"".FThemePath."/css",$output);
$output = str_replace(array("href=\"/asset", "href=\"asset"), "href=\"".FThemePath."/asset",$output);
$output = str_replace(array("src=\"/asset", "src=\"asset"), "src=\"".FThemePath."/asset",$output);
$output = str_replace(array("href=\"/assets", "href=\"assets"), "href=\"".FThemePath."/asset",$output);
$output = str_replace(array("src=\"/assets", "src=\"assets"), "src=\"".FThemePath."/asset",$output);
$output = str_replace(array("src=\"/js","src=\"js"), "src=\"".FThemePath."/js",$output);
$output = str_replace(array("src=\"/image", "src=\"image"), "src=\"".FThemePath."/image",$output);
$output = str_replace(array("href=\"/image", "href=\"image"), "href=\"".FThemePath."/image",$output);
$output = str_replace(array("src=\"/img","src=\"img"), "src=\"".FThemePath."/img",$output);		
$output = str_replace(array("src=\"/media","src=\"media"), "src=\"".FUrl."/media",$output);		
$output = str_replace(array("href=\"/media","href=\"media"), "href=\"".FUrl."/media",$output);		
$output = str_replace(array("{sitetitle}","{siteTitle}"), SiteTitle ,$output);
$output = str_replace(array("{siteHome}","{siteUrl}","{homeurl}"),FUrl,$output);
$output = str_replace(array("{sitename}","{siteName}"),SiteName,$output);
$output = str_replace(array("{siteKeys}","{sitekeys}","{homeurl}"),SiteKeys,$output);
$output = str_replace(array("{siteDesc}","{sitedesc}"),SiteDesc,$output);
$output = str_replace(array("{pagetitle}","{pageTitle}"),PageTitle,$output);
$output = str_replace(array("{metadesc}","{metaDescription}"),MetaDesc,$output);
$output = str_replace(array("{metakeys}","{metaKeywords}"),MetaKeys ,$output);
$output = str_replace(array("{metaauthor}","{metaAuthor}"),MetaAuthor,$output);
$output = str_replace(array("{metarobots}","{metaRobots}"),MetaRobots,$output);
$output = str_replace(array("{layout}"),FLayout('name'),$output);
$output = str_replace(array("{layoutDesc}","{layoutdesc}"),FLayout('desc'),$output);
$output = str_replace(array("{metarobots}","{metaRobots}"),MetaRobots,$output);
$output = str_replace("{lang}",SiteLang,$output);
$output = str_replace("{lang}",SiteLang,$output);
if(checkMobile()) $m = "m-"; else $m = "";
$output = str_replace("{m-}",$m,$output);
$output = str_replace(array("{pid}","{PID}"),Page_ID,$output);		
if(isHomePage()) $h = "home"; else $h = "default";
$output = str_replace("{home}",$h,$output);
if(USER_ID) {
    $output = str_replace("{userid}",USER_ID,$output);
    $output = str_replace("{username}",USER_NAME,$output);
    $output = str_replace("{userlevel}",USER_LEVEL,$output);		
} else {		
    $output = str_replace("{userid}",'',$output);
    $output = str_replace("{username}",'',$output);
    $output = str_replace("{userlevel}",'',$output);	
}
	
$tlb = strpos($output,"</body>");
$ntb = substr($output ,$tlb );
$output = str_replace($ntb, $jsasset.$ntb,$output);	
ob_end_clean();

ob_start();
$output = preg_replace('#^\s*//.+$#m', "", $output);
$output = preg_replace('/<!--(.*)-->/Uis', "", $output);
$output = preg_replace(array('(( )+\))','(\)( )+)'), ')', $output);
//$output = str_replace(array("\t","\n"), ' ', $output);
$output = str_replace(array("  ","   "), ' ', $output);
$output = str_replace("  ", ' ', $output);



/* timer */
$et = microtime(TRUE) - _START_TIME_;
$et = substr($et,0,6)."s";

$output = str_replace(array("{loadtime}","{loadTime}"),$et,$output);
/* timer */

if(Input::server('https') == 'on') $output = str_replace("http://", "https://", $output);
echo $output;
ob_end_flush();