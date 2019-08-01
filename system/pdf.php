<?php
/** 
 * Adds a custom validation rule using a callback function.
 * @version		3.0
 * @package		Fiyo CMS
 * @copyright	Copyright (C) 2018 Fiyo CMS.
 * @license		GNU/GPL, see LICENSE.
 */


class PDF extends GUMP {
    public static $req;
    public static $post;
    public static $get;
    public static $session;
    private static $file;
    private static $_instance = null;
	
	
	public function __construct( ){				
		require_once(dirname(__FILE__).'/../../../../pdf/html2pdf.class.php');
        self::$post = $_POST;	
        self::$get = $_GET;	
        self::$session = $_SESSION;	
	}
	
	if(isset($_GET['print'])) {
		require_once(dirname(__FILE__).'/../../../../pdf/html2pdf.class.php');
	
		// get the HTML
		 ob_start();
			include('print/template.print.php');
		$content = ob_get_clean();
	echo $content;
		try
		{
			// init HTML2PDF
			$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
	
			// display the full page
			$html2pdf->pdf->SetDisplayMode('fullpage');
	
			// convert
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	
			// add the automatic index
	
			// send the PDF
			$html2pdf->Output('about.pdf');
	
	
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	 } else {
	
	
	
	 }
}

class_alias('Input', 'Req');
class_alias('GUMP', 'Validator');
new Input();
	
foreach($_GET as $key => $val) {
        if(isset($_GET[$key])){
         if(strpos($key,"entities"))
            $_GET[$key] = htmlentities($_GET[$key], ENT_QUOTES);
        else  if(strpos($key,"unstrip")  or is_array($_GET[$key]))
            $_GET[$key] = $_GET[$key];
        else
            $_GET[$key] = strip_tags($_GET[$key]);
    }
}

foreach($_POST as $key => $val) {
    if(isset($_POST[$key])){
        if(strpos($key,"entities"))
            $_POST[$key] = htmlentities($_POST[$key], ENT_QUOTES);
        else  if(strpos($key,"unstrip") or is_array($_POST[$key]))
         $_POST[$key] = $_POST[$key];
        else
            $_POST[$key] = strip_tags($_POST[$key]);
    }
}

