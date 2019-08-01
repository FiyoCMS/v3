<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$kamus = [
    "{no_surat}" => "nosurat 13123123",
    "{nip}" => "123123123",
    "{nama}" => "asdsdssdsd",
];


$cetak = new Printer($kamus);
$cetak->cetak();

?>