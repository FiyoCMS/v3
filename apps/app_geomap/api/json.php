<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');
header('Content-Type: application/json');

$get = Input::$get;
$filter = '';
$arr = false;
$i = 0;

foreach($get as $x => $y){
    if(is_array($y)) {        
        if($i != 0) 
        $filter .= " AND ";
        $j = 0;
        foreach($y as $m) {
            if($j != 0) 
                $filter .= " OR ";
                
            $filter .= "$x= '$m'";
            $j++;
        }
    $i++;
    }
}

echo json_encode([$filter]);