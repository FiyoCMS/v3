
<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
header('Content-Type: application/json');

if(Input::get('table')) {
    $table = Input::get('table');
    
    $qr = "SELECT TABLE_NAME, COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME LIKE '%$table%'";

    $sql =  DB::query($qr, true);    
    //print_r($sql);

    $cols = "";
    foreach($sql as $row) {
        $cols .=  "'".$row['COLUMN_NAME']. "'" . "," . "\n";
    }

    $cols2 = "";
    foreach($sql as $row) {
        $cols2 .=  "'".$row['COLUMN_NAME']. "' => \$tmp['$row[COLUMN_NAME]']" . "," . "\n";
    }


    $dataTable = "";
    foreach($sql as $row) {
        $dataTable .=  "echo \"<td>\" . angka(\$row['".$row['COLUMN_NAME']. "']) . \"</td>\";" . "\n";
    }

    echo "\n".$cols;

    echo "\n".$cols2;

    
    echo "\n".$dataTable;

}