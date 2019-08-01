<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$_REQUEST['id']=0;

if(isset($_POST['next']) or isset($_POST['apps'])) {
	if(empty($_POST['apps'])) {
		echo '<div class="alert error" id="status">'.Please_Select_Apps.'</div>';
		 addappstep1();
	}
	else {			
		addappstep2();
	}
}
else {
	addappstep1();
}
	
function addappstep1() {
?>
<script type="text/javascript" charset="utf-8">
if (!$.isFunction($.fn.dataTable) ) { alert();
	var script = '../plugins/plg_jquery_ui/datatables.js';
	document.write('<'+'script src="'+script+'" type="text/javascript"><' + '/script>');	
}	
$(function() {
	$("#form").submit(function(e){
			var ff = this;
			var checked = $('input[name="check_category[]"]:checked').length > 0;
			if(checked) {	
				e.preventDefault();
				$('#confirmDelete').modal('show');	
				$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Delete); ?>");
			$('input[name="check_category[]"]').next().addClass('input-error');
			return false;
		}
	});
	loadTable();
});
</script>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_Menu; ?></div>			
			<div class="app_link">
				<a class="btn btn-default btn-grad" href="?app=menu" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i>&nbsp;<?php echo Prev; ?></a>
				<button type="submit" class="btn btn-success  btn-grad" title="<?php echo Delete; ?>" value="Next" name="next"><?php echo Next; ?> &nbsp;<i class="icon-arrow-right"></i></button>
			</div>
		</div>			 
	</div>
	<table class="data">
		<thead>
			<tr>
				<th style="width:1%; text-align:center" class="no" ></th>
				<th style="width:20% !important;"><?php echo Menu_Type_or_Apps_Name; ?></th>
				<th style="width:18% !important;"><?php echo AddOns_Author; ?></th>
				<th style="width:61% !important;"><?php echo Description; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql =	DB::table(FDBPrefix.'apps')
				->where('type <= 1')
				->orderBy("name ASC")
				->get(); 
			
			$apps_date = $apps_version = '-';
			foreach($sql as $row){	
					$file = "../apps/$row[folder]/app_details.php";
					$app_desc = '';
					if(file_exists($file))
					include("../apps/$row[folder]/app_details.php");
					echo "<tr target-radio='$row[folder]'>";
					
					echo "<td class='text-center'><label><input type=\"radio\" name=\"apps\" value=\"$row[folder]\" data-name='$row[folder]' target-radio='$row[folder]'></label>
					</td><td><a>$row[name]</a></td><td>$row[author]</td>
					<td>$app_desc</td>";
					echo "</tr>";
				}
			?> 
			<tr target-radio="link">
				<td class="text-center"><label><input type="radio" name="apps" value="link" target-radio="link" data-name="link"></label></td>
				<td><a data-placement='right' class='tips' ><?php echo External_Link; ?></a></td>
				<td>Fiyo CMS</td>
				<td><?php echo External_Link_tip; ?></td>
			</tr>
			<tr target-radio="sperator">
				<td class="text-center"><label><input type="radio" name="apps" value="sperator" target-radio="link" data-name="sperator"></label></td>
				<td><a data-placement='right' class='tips' ><?php echo Sperator; ?></a></td>
				<td>Fiyo CMS</td>
				<td><?php echo Sperator_tip; ?></td>
			</tr> 
        </tbody>			
	</table>
</form>			
<?php
}

function addappstep2() {
echo Form::open(['url' => '', 'method' => 'post']);
?>
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_Menu; ?></div>	
			<div class="app_link">				
				<a class="btn btn-default sm btn-grad" href="?app=menu&view=add" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> </a>				
				<span class="lbt sparator"></span>
								
				<button type="submit" class="btn btn-success btn-grad" title="<?php echo Delete; ?>" value="Next" name="save"><i class="icon-check"></i> <?php echo Save; ?></button>

				</button>				
				<a class="danger btn btn-default  btn-grad" href="?app=menu" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a><?php printAlert(); ?>
			
			</div>
		</div>
	</div>
	<?php 
		require('field_menu.php');
	?>		
</form>		
<?php
}