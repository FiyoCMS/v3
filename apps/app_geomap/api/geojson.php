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


$get = Input::$get;
$filter = '';
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

$qr = DB::table(FDBPrefix."bencana_banjir")
    ->leftJoin(FDBPrefix."zona_kecamatan","id_kecamatan = kecamatan")
    ->where("$filter")
    ->get();

$attr = [];
$i = 0;
foreach($qr as $geo) {
    $attr[$i]['geometry'] = json_decode($geo['geometry'], true);        
    $attr[$i]['properties'] = [
        "kecamatan" => $geo['nama_kecamatan'],
        "kelas" => $geo['kelas'],
        "area" => $geo['area'],
        "lokasi" => $geo['lokasi']
    ];
    $attr[$i]['type'] = 'Feature';  
    $attr[$i]['id'] = $i;  
    $i++;
}
$map = [
    "type" => "FeatureCollection",
    "name" => "AncamanBanjir",
    "features" => $attr,
];

echo "data_banjir = " .json_encode($map). ";";