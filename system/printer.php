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
    static $page = null;

    function __construct($reff, $page = null) {
        self::$reff = $reff;
        self::$page = $page;
    }
    public function cetak() {
        if(defined('DONT_PRINT')) return false;
        //inisiasi referensi halaman

        if(app_param('page'))
            $reff = app_param('page');
        else
            $reff = self::$page ;

        $kamus = self::$reff;
        if(!count(self::$reff)) $kamus = [];

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

        include( basename(FAdmin) . "/../apps/app_print/print/assets/print.main.php");
    }
}
?>