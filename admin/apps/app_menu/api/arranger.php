<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 2 AND !Input('stat')) die ();


/****************************************/
/*		    Make Default Page			*/
/****************************************/ 
$data =Input::get('data');
$id =Input::get('id');

//get json data array
$data2 = json_decode($data); 
objToArray($data2, $ar);

//set default to false for $qr (output)
$qr = false;
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

       
if($qr) {
    $return = [
        'status' => 'success',
        'text' => Status_Saved
    ];
}
else {
    $return = [
        'status' => 'error',
        'text' => Status_Fail
    ];
} 

echo json_encode($return);