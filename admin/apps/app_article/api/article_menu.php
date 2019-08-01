<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(!USER_LEVEL) die ();

?>
<script type="text/javascript">

function iniTable () {
	if ($.isFunction($.fn.dataTable)) {	
		$('table.data').show();	
		var cat = $('.category').val();
		var user = $('.user').val();
		var level = $('.level').val();
		
		oTable = $('table.data').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "?app=article&api=article-list&param=true",
			"bJQueryUI": true,  
			"sPaginationType": "full_numbers",
			"fnDrawCallback": function( oSettings ) {
				$(".select").click(function() {
					$("#selectArticle").modal('hide');
					var id = $(this).attr('rel');	
					var name = $(this).html();	
					$("#link").val("?app=article&view=item&id="+id);
					$("#pg").val(name);
				});
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
		
				
				$('input[type="checkbox"],input[type="radio"]').wrap("<label>");
				$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");
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
</script>

<script type="text/javascript">	
$(function() {	

	$('.filter').change(function () {
		oTable.fnDestroy();
		iniTable();		
	});
	
	iniTable();
});
</script>
<form method="post">	
        <table class="data">
		<thead>
			<tr>								
				<th style="width:30% !important;"><?php echo Article_Title; ?></th>
				<th style="width:10% !important;text-align:center" class='hidden-xs'><?php echo Category; ?></th>
				<th style="width:15% !important;text-align:center" class='hidden-xs'><?php echo Author; ?></th>
				<th style="width:12% !important;text-align:center" class='hidden-xs'><?php echo Access_Level; ?></th>
				<th style="width:15% !important;text-align:center" class='hidden-xs'><?php echo Date; ?></th>
			</tr>
		</thead>		
		<tbody>
			<tr><td colspan="8" align="center">Loading...</td></tr>	
        </tbody>			
	</table>
</form>
