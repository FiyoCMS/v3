<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$new_member = siteConfig('new_member');
if($new_member){$enpar1="selected checked"; $dispar1 = "";}
else {$dispar1="selected checked"; $enpar1= "";}

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
			noticeabs("<?php echo alert('error',Please_Select_Delete); ?>");
			$('input[name="check[]"]').next().addClass('input-error');
			return false;
		}
	});
	
function iniTable () {
	if ($.isFunction($.fn.dataTable)) {	
		$('table.data').show();	
		var level = $('.level').val();
		
		oTable = $('table.data').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "?app=user&api=datalist",
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
				$(".editor.activator label").click(function(){
					var parent = $(this).parents('.switch');
					var id = $('.number',parent).attr('value');	
					var value = $('.type',parent).attr('value');
					if(value == 1) value = 0; else value = 1;
					$.ajax({
						url: "?app=user&api=status&stat="+value+"&id="+id,
						success: function(data){
						if(value == 1)
							$('.type',parent).val("1");
						else 
							$('.type',parent).val("0");				
							notice(data);	
						}
					});
				});
											
				$(".editor .cb-enable").click(function(){		
					var parent = $(this).parents('.switch');
					$('.cb-disable',parent).removeClass('selected');
					$(this).addClass('selected');
					$('.checkbox',parent).attr('checked', false);	
				});
				$(".editor .cb-disable").click(function(){		
					var parent = $(this).parents('.switch');
					$('.cb-enable',parent).removeClass('selected');
					$(this).addClass('selected');
					$('.checkbox',parent).attr('checked', false);	
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
			<div class="app_title"><?php echo User_Manager; ?></div>
			<div class="app_link">			
				<a class="add btn btn-primary" href="?app=user&act=add" title="<?php echo New_User; ?>"><i class="icon-plus"></i> <?php echo New_User; ?></a>
				<button type="submit" class="delete btn btn-danger" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
				<?php printAlert(); ?>
			</div>
		</div>		 
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check[]"></th>				
				<th style="width:30% !important;"><?php echo Name; ?></th>
				<th style="width:20% !important;">Username</th>
				<th style="width:25% !important;" class='hidden-xs'>Email</th>
				<th style="width:5% !important; text-align: center;" class="no">Status</th>
				<th style="width:20% !important; " class='hidden-xs'>Group</th>
				<th style="width:5% !important;text-align: center;" class='hidden-xs'>ID</th>
			</tr>
		</thead>	
		<tbody>
			<tr><td colspan="8" align="center">Loading...</td></tr>	
        </tbody>			
	</table>
</form>