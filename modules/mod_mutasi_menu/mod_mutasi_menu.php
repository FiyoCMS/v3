<?php
if(!isset(session('PEGAWAI_LAST_DATA')['kategori']) or !session('PEGAWAI_LAST_DATA')['kategori'])
    require_once('mutasi_menu.default.php');
else    
    require_once('loggedin.php');

    ?>
