<?php

namespace Cetak;

/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


class Printer {

    function __construct() {

    }
    public function cetak() {
        //inisiasi referensi halaman
        $reff = app_param('page');
        include("kamus.php");
        if(!isset($kamus)) $kamus = [];

        //query database
        $data =DB::table(FDBPrefix."print_page")
            ->select("*, ".FDBPrefix."print_kop.text as kop")
            ->where(FDBPrefix."print_page.name = '$reff'")
            ->leftJoin(FDBPrefix."print_kop", "kop_id = kop")
            ->get();

        if($data) $data = $data[0];
        else $data = null;

        $kop    = $data['kop'];
        $line   = $data['line'];
        $text   = $data['main'];

        //Print to HTML
        $text = strtr($text, $kamus);

        //kop + text di gabung jadi 1 dokumen
        $page = [$kop, $line, $text];


        $pages = explode(",",$data['pages']);
        $count = count($pages);

        if($count) :
        $tmpPage = [$page];
        for($i = 0; $i < $count; $i++) :

            /************************** HALAMAN 1 *************************/
            //inisiasi referensi halaman
            $reff = $pages[$i];

            //query database
            $data =DB::table(FDBPrefix."print_page")
                ->select("*, ".FDBPrefix."print_kop.text as kop")
                ->where(FDBPrefix."print_page.name = '$reff'")
                ->leftJoin(FDBPrefix."print_kop", "kop_id = kop")
                ->get();

            if($data) $data = $data[0];
            else $data = null;

            $kop    = $data['kop'];
            $line   = $data['line'];
            $text   = $data['main'];

            //Print to HTML
            $text = strtr($text, $kamus);

            //kop + text di gabung jadi 1 dokumen
            array_push($tmpPage, [$kop, $line, $text]);

        endfor;
        endif;


        //gabung beberapa jenis dokumen/lembar array

        $pages = $tmpPage;


        include("assets/print.main.php");



    }
}
?>