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
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Article_category; ?></div>
			<div class="app_link">			
			<a class="add btn btn-primary" href="?app=article&view=category&act=add" title="<?php echo Add_new_category; ?>"><i class="icon-plus"></i> <?php echo New_Category; ?></a>
			<button type="submit" class="delete btn btn-danger" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_category"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
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
				<th style="width:15% !important;text-align:center" class='hidden-xs'><?php echo Access_Level; ?></th>
				<th style="width:15% !important;text-align:center" class='hidden-xs'>Total <?php echo Article; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php		
			$tb1 = FDBPrefix.'article_category';
			$tb2 = FDBPrefix.'user_group';	
			$sql = DB::table($tb1)
				->select("$tb1.id,name,parent_id,$tb1.description, $tb1.level, group_name")
				->where("parent_id=0")
				->leftJoin($tb2,"$tb2.level= $tb1.level")
				->get();			
			$no = 1; 
			foreach($sql as $row){				
				$jml = DB::table(FDBPrefix.'article')
					->select('COUNT(*) AS count')
					->where('category='.$row['id']) -> get()[0]['count']; 

				//creat user group values	
				if($row['level']==99) 
					$level = _Public;				
				else {						
					$level = $row['group_name'];
				}					
								
				if($_SESSION['USER_LEVEL'] <= $row['level']) {
				$name = "<a class='tips' data-placement='right' title='".Edit."' href='?app=article&view=category&act=edit&id=$row[id]'>$row[name]</a>";
				$checkbox ="<input type='checkbox' data-name='rad-$row[id]' name='check_category[]' value='$row[id]' rel='ck'>";
				}
				else {$checkbox ="<span class='icon lock'></lock>";
				$name = "$row[name]";}
				
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name <span class='label label-primary right visible-xs'>$jml</span></td><td align='center' class='hidden-xs'>$level</td><td align='center' class='hidden-xs'>$jml</td>";
				echo"</tr>";
				sub_article($row['id'],"<span style='display: none'>$name</span>" );
				$no++;	
				
			}					
			?>
        </tbody>			
	</table>
</form>