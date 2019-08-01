<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID'])) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');

$so = FDBPrefix."statistic_online";
$row = DB::Table("$so")->select("COUNT(*) AS val")->get();
$online = angka($row[0]['val']);

$st = FDBPrefix."statistic";
$row = DB::Table("$st")->select("COUNT(*) AS val")->get();
$total = angka($row[0]['val']);

$dtf = date('Y-m-d 00:00:00');
$row = DB::Table("$st")->select("COUNT(*) AS val")->where("time >= '$dtf'")->get();
$today = angka($row[0]['val']);

$dtf = date('Y-m-d 00:00:00',strtotime("-1 Months"));
$row = DB::Table("$st")->select("COUNT(*) AS val")->where("time >= '$dtf'")->get();
$month = angka($row[0]['val']);
	
$timer = time() - 300;
DB::table(FDBPrefix.'statistic_online')->delete("time < $timer");

echo "
{ \"today\":\"$today\" , \"month\":\"$month\", \"total\":\"$total\", \"online\":\"$online\" }";
