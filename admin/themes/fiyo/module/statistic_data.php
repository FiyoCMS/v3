<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2016 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');


if(checkMobile()) {
	$d13 = 6;
} else {
	$d13 = 9;
}

$uniqueVisitor = $allVisitor = $newVisitor = $dateList = '';

$x = $d13;
$dtf = date('Y-m-d 00:00:00',strtotime("-$x days"));
$z = $x-1;
$dts = date('Y-m-d 00:00:00',strtotime("0 days"));	
$st = FDBPrefix."statistic";


$d = dateRange($dtf, $dts,"+1 days" ,'Y-m-d');

$date = [];
$visit = [];
for($i = 0; $i <= $d13; $i++) {
    $c = DB::table(FDBPrefix.'statistic')
    ->select("COUNT(id) as visit")
    ->where("DATE_FORMAT(time,'%Y-%m-%d') = '$d[$i]'")
    ->get();
 
    $newDate = date("M' d", strtotime($d[$i]));
    array_push($date, $newDate);
    array_push($visit, (int)$c[0]['visit']);
}


$unique = [];
for($i = 0; $i < $d13; $i++) {
    $c = DB::table(FDBPrefix.'statistic')
    ->select("COUNT(ip) as visit")
    ->where("DATE_FORMAT(time,'%Y-%m-%d') = '$d[$i]'")
    ->groupBy("ip")
    ->get();
    if(!isset($c[0])) 
        $a = 0;
    else
        $a = (int)$c[0]['visit'];
    
    array_push($unique, $a);
}


header('Content-Type: application/json');
$return = ["status" => "ok", "data" => ['date' => $date, 'visitor' => $visit, 'unique' => $unique]];
echo json_encode($return);
