<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

class Printer {
    static $reff = [];

    function __construct($reff) {
        self::$reff = $reff;
    }
    public function cetak() {
        //inisiasi referensi halaman
        $reff = app_param('page');

        if(count(self::$reff)) $kamus = [];

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

        //load template file
        include(__dir__ . "/../print/assets/print.main.php");
    }
}
?>