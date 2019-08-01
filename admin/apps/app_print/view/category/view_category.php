<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>	
<script type="text/javascript">
if (!$.isFunction($.fn.dataTable) ) {
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
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title">Kategori Cetak</div>
			<div class="app_link">			
			<a class="add btn btn-primary btn-grad" href="?app=reports&view=category&act=add" title="<?php echo Add; ?>"><i class="icon-plus"></i> <?php echo Add; ?></a>
			<button type="submit" class="delete btn btn-danger btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_category"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
			</div>
			<?php printAlert('NOTICE'); ?>
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target='check_category[]'></th>		
				<th style="width:70% !important;"><?php echo Category_Name; ?></th>	
				<th style="width:15% !important;text-align:center" class='hidden-xs'>Total </th>
			</tr>
		</thead>
		<tbody>
			<?php		
			$tb1 = FDBPrefix.'reports_category';
			$sql = DB::table($tb1)
				->get();			
			$no = 1; 
			foreach($sql as $row){				
				$jml = DB::table(FDBPrefix.'reports_page')
					->select('COUNT(*) AS count')
					->where('category='.$row['cat_id']) -> get()[0]['count']; 
		
								
				$name = "<a class='tips' data-placement='right' title='".Edit."' href='?app=reports&view=category&act=edit&id=$row[cat_id]'>$row[cat_name]</a>";
				$checkbox ="<input type='checkbox' data-name='rad-$row[cat_id]' name='check_category[]' value='$row[cat_id]' rel='ck'>";
				
				
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name <span class='label label-primary right visible-xs'>$jml</span></td><td align='center' class='hidden-xs'>$jml</td>";
				echo"</tr>";
				sub_article($row['cat_id'],"<span style='display: none'>$name</span>" );
				$no++;	
				
			}					
			?>
        </tbody>			
	</table>
</form>