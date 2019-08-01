<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$line = ["",
    "<div class='kop-style-1'></div>",
    "<div class='kop-style-2a'></div><div class='kop-style-2b'></div>",
    "<div class='kop-style-3a'></div><div class='kop-style-3b'></div>",
];

$isi = "";


?>
<!-- FIRST PAGE -->
<div class="container">
    <div id="top">
        <?php echo $data[0]; ?>
        <?php echo $isi; ?>
    </div>
    <div id="main">
        <?php  
        
        if(checkLocalhost()) {
            echo str_replace("media/",FLocal."media/",$data[2]);			
        } 
        else 
            echo 
            $data[2]; 

        ?>
    </div>

    <div id="footer">
    </div>
</div>
<!-- END OF PAGE -->

            
