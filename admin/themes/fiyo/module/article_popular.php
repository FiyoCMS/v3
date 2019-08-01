<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
require_once ('../../../system/jscore.php');
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > siteConfig('special_level') or !isset($_GET['url'])) die();
define('_FINDEX_','BACK');


?>

<table class="table table-striped tools">
  <tbody>
	<?php	
		$sql = DB::Table(FDBPrefix."article")->select("*,DATE_FORMAT(date,'%W, %b %d %Y') as date")->orderBy('hits DESC')->limit(10)->get(); 
		$no = 0;
		foreach($sql as $row) {		
			$no++;	
			$h = $row['hits'];
			if($h > 999) {
				$h = $h / 1000;
				$h = substr($h,0,3);
				$c = substr($h,2);
				if($c == 0)	
					$h = substr($h,0,1);
				$h = $h."k";	
			}
			$h = angka($h);
			$read = $_GET['url'].check_permalink("link","?app=article&view=item&id=$row[id]","permalink");
			$edit = "?app=article&act=edit&id=$row[id]";						
			$auth = userInfo("name","$row[author_id]");
			$info = ": <b> $h</b> view(s)";
			$read_article = Read;
			$edit_article = Edit;		
			echo "<tr><td class='no-tabs'>#$no</td><td width='100%'>$row[title] $info
			<div class='tool-box'>
				<a href='$read' target='_blank'  class='btn btn-tools tips' title='$read_article'>$read_article</a>";				
			$editor_level 	= mod_param('editor_level',$row['parameter']);
			if($editor_level >= USER_LEVEL or empty($editor_level)) echo "<a href='$edit' class='btn btn-tools tips' title='$edit_article'>$edit_article</a> ";
			echo "</div></td></tr>";
		}		
		if($no == 0) { 
			echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Article."</td></tr>";
		}							
		?>				
       </tbody>			
</table>
<script>$(function() {$('.tooltips').tooltip();});</script>