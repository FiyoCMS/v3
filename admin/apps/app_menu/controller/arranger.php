<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2 AND !isset($_GET['stat'])) die ();
define('_FINDEX_','BACK');
require_once ('../../../system/jscore.php');
/****************************************/
/*		    Make Default Page			*/
/****************************************/ 	
if(isset($_GET['default'])) {
	alert('success',$_GET['id']);
	$qr = DB::table(FDBPrefix.'menu')->where('id!='.$_GET['id'])->update(["global"=>"0"]);
	$qr = DB::table(FDBPrefix.'menu')->where('id='.$_GET['id'])->update(["global"=>"1"]);
	if($qr) alert('success',Status_Applied,1);
}

$data = $_GET['data'];
$data2 = json_decode($data); 
objToArray($data2, $ar);


$dump = [];
$n = 1;
foreach($ar as $a => $k) {
    array_push($dump,[$n, $k['id'], 0]);
     //query here
	$qr = DB::table(FDBPrefix.'menu')->where('id='.$k['id'])->update(["parent_id"=>"0", "short" => $n]);
     //till here
    if(isset($k['children'])) {
        $subs = subs($k['children'], $k['id']);
        array_push($dump,$subs);
    }
    $n++;
}

if($qr) alert('success',Status_Applied,1);

function subs($arr, $parent) {
    $dump = [];
    $i = 1;
    foreach($arr as $a => $k) {
        array_push($dump,[$i, $k['id'] , $parent]);
        //query here
	    $qr = DB::table(FDBPrefix.'menu')->where('id='.$k['id'])->update(["parent_id"=>$parent, "short" => $i]);
        //till here
        if(isset($k['children'])) {
            $subs = subs($k['children'], $k['id']);
            array_push($dump,$subs);
        }
        $i++;
    }
    return $dump;
}


function objToArray($obj, &$arr){

    if(!is_object($obj) && !is_array($obj)){
        $arr = $obj;
        return $arr;
    }

    foreach ($obj as $key => $value)
    {
        if (!empty($value))
        {
            $arr[$key] = array();
            objToArray($value, $arr[$key]);
        }
        else
        {
            $arr[$key] = $value;
        }
    }
    return $arr;
}

?>
<script>notice();</script>