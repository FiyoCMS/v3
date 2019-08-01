<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');
header('Content-Type: application/javascript');

$file = "../data/bangunansitemap.txt";

$type = app_param('type');
if($type)
$file = "../data/bencana/$type.json";

$kec = app_param('kec');
if($kec)
$file = "../data/bencana/$type.json";


echo "   var data_bencana_$type = {};";
  $i = 0;
if(file_exists($file)) {
    echo "data_bencana_$type = ";
    $file = fopen($file, "r");
    
    //Output lines until EOF is reached
    while(!feof($file)) {
      $line = fgets($file);
      echo $line;
      //$i++;
    }
    
    fclose($file);   


}