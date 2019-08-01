<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or !isset($_GET['url'])) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
?>
<table class="table table-striped tools">
  <tbody>
	<?php	
		$suser = FDBPrefix."user";
		$sgroup = FDBPrefix."user_group";
		$sql = DB::table("$suser")->select("*,DATE_FORMAT(time_log,'%W, %Y-%m-%d %H:%i') as date")->where("time_log != '0000-00-00 00-00-00' AND $suser.level >= $_SESSION[USER_LEVEL]")->orderBy('time_log DESC')->limit('10')
		->leftJoin("$sgroup", "$suser.level = $sgroup.level")
		->get(); 
		$no = 1;
		foreach($sql as $row) {
			$id = $row['id'];
			$edit = Edit;
			$read = Read;
			$hide = Set_disable;	
			$delete = Delete;
			$approve = Set_enable;		
			$sql2 = DB::Table(FDBPrefix."user_group","*","level=$row[level]"); 
			
			$red = '';
			if($row['status']) 
				$approven = "<a class='btn-tools btn btn-danger btn-sm btn-grad disable-user' data-id='$row[id]' title='$hide'>$hide</a><a class='btn-tools btn btn-success btn-sm btn-grad approve-user' data-id='$row[id]' title='$approve' style='display:none;'>$approve</a>";
			else {
				$approven = "<a class='btn-tools btn btn-success btn-sm btn-grad approve-user' data-id='$row[id]' title='$approve'>$approve</a><a class='btn-tools btn btn-danger btn-sm btn-grad disable-user' data-id='$row[id]' title='$hide' style='display:none;'>$hide</a>";
				$red = "class='unapproved'";
			}		
			if($id == USER_ID) $approven ='';
			$output = oneQuery('session_login','user_id',"'$id'");	
			$log = "";			
			if($output) $log = "
			<a data-toggle='tooltip' data-placement='right' title='Online' class=' icon-circle blink icon-mini tooltips'></a>&nbsp;&nbsp;&nbsp;";
			
			$group = $row['group_name'];			
			$ledit = "?app=user&act=edit&id=$row[id]";					
			echo "<tr $red>
			<td>$row[name] <span>($row[user])</span>$log
			<a data-toggle='tooltip' data-placement='right' title='$row[email]' class=' icon-envelope-alt tooltips'></a>
			<a data-toggle='tooltip' data-placement='right' title='$group' class=' icon-info-sign tooltips'></a>
			<br/>
			<div class='tool-box'>
				$approven
				<a href='$ledit' class='btn btn-tools tips' title='$edit'>$edit</a>
			</div></td>
			<td align='right'>$row[date]</td>
			</tr>";
			$no++;	
		}					
		?>			

       </tbody>			
</table>
<script>$(function() {	
	$('.approve-user').click(function() {
		var is = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat=1&id="+id,
			success: function(data){						
				is.parents("tr").removeClass('unapproved');
				is.hide();
				is.parent().find('.disable-user').show();
			}
		});		
	});
	
	$('.disable-user').click(function() {
		var is = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat=0&id="+id,
			success: function(data){
				is.parents("tr").addClass('unapproved');
				is.hide();
				is.parent().find('.approve-user').show();
			}
		});	
	});
	$('.tooltips').tooltip();
}); 
</script>