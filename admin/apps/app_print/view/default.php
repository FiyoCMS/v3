<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

printAlert('NOTICE');

$_GET['cat'] = $_GET['level'] = $_GET['user'] = '';
?>
<script type="text/javascript">	
$(function() {		
	$("#form").submit(function(e){
		e.preventDefault();
		var ff = this;
		var checked = $('input[name="check[]"]:checked').length > 0;
		if(checked) {	
			$('#confirmDelete').modal('show');	
			$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Article_Not_Select); ?>");
			$('input[name="check[]"]').next().addClass('input-error');
			return false;
		}
	});
	
oTable = "";
function iniTable () {
	if ($.isFunction($.fn.dataTable)) {
		$('table.data').show();	
		var cat = $('.category').val();
		
		console.log(cat);
		oTable = $('table.data').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "?app=<?php echo app_param('app'); ?>&api=page-list&cat="+cat,
			"bJQueryUI": true,  
			"sPaginationType": "full_numbers",
			"fnDrawCallback": function( oSettings ) {
				selectCheck();
				$('[data-toggle=tooltip]').tooltip();
				$('[data-tooltip=tooltip]').tooltip();
				$('.tips').tooltip();			
				$("tr").click(function(e){
					var i =$("td:first-child",this).find("input[type='checkbox']");					
					var c = i.is(':checked');
					if($(e.target).is('.switch *, a[href]')) {					   
					} else if(i.length){
						if(c) {
							i.prop('checked', 0);		
							$(this).removeClass('active');			
						}
						else {
							i.prop('checked', 1);
							$(this).addClass('active');
						}
					}
				});			
				
				$('table.data tbody a[href]').on('click', function(e){
				   if ($(this).attr('target') !== '_blank'){
					e.preventDefault();	
					loadUrl(this);
				   }				
				});
			}
			
		});
		
		
		$('table.data th input[type="checkbox"]').parents('th').unbind('click.DT');
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}
	}
}
	$('.filter').change(function () {
		oTable.fnDestroy();
		iniTable();		
	});
	
	iniTable();
});
</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">				
			<div class="app_title">Template Cetak</div>
			<div class="app_link">			
				<a class="add btn btn-primary" Value="Create" href="?app=<?php echo $app['root'];?>&act=add" title="<?php echo Add; ?>"><i class="icon-plus"></i> <?php echo Add; ?></a>
				<button type="submit" class="delete btn btn-danger btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
						
				<span class="filter-table visible-lg-inline-block">
					<span>
						<?php echo Category; ?>
						<select name="cat" class="category filter"  data-placeholder="<?php echo Choose_category; ?>" style="min-width:120px;">
						<option>All</option>
						<?php	
							$_GET['id']=0;
							$sql =DB::table(FDBPrefix.'reports_category')->get(); 
							foreach($sql as $rowc){
								if($_GET['cat_id']==$rowc['cat_id']) $s="selected";else$s="";
								echo "<option value='$rowc[cat_id]' $s>$rowc[cat_name]</option>";
							}						
						?>
						</select>
					</span>
					
				</span>
		  </div> 	
		</div>
	</div>
	
	<table class="data article-list">
		<thead>
			<tr>							
				<th style="width:1% !important;" class="no" colspan="0">  
					<input type="checkbox" id="checkall" target="check[]"></th>		
				<th style="width:30%; max-width: 350px;" class="article_list">Judul Template</th>	<th style="width:15% !important;text-align:center" class='hidden-xs'><?php echo Category; ?></th>
		
				<th style="width:10% !important;">Nama Unik</th>
				</tr>
		</thead>		
		<tbody>
			<tr><td colspan="5" align="center">Loading...</td></tr>	
        </tbody>			
	</table>
</form>
