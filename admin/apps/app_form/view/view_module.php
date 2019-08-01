<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>	
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$(".activator label").click(function(){ 
		var parent = $(this).parents('.switch');
		var id = $('.number',parent).val();	
		var value = $('.type',parent).val();
		if(value == 1) value = 0; else value = 1;
		$.ajax({
			url: "apps/app_test/controller/status.php",
			data: "stat="+value+"&id="+id,
			success: function(data){	
				if(value == 1) {
					$('.type',parent).val("1");
				}
				else 
					$('.type',parent).val("0");				
				notice(data);		
			}
		});
	});
	$(".home label").click(function(){ 
		var parent = $(this).parents('.switch');
		var id = $('.number',parent).attr('value');	
		var value = $('.type',parent).attr('value');
		if(value == 1) value = 0; else value = 1;
		$.ajax({
			url: "apps/app_test/controller/status.php",
			data: "name="+value+"&id="+id,
			success: function(data){
				if(value == 1)
					$('.type',parent).val("1");
				else 
					$('.type',parent).val("0");				
				notice(data);		
			}
		});
	});
	
	$(".cb-enable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
	});
	
	$(".cb-disable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
	});
	
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
	loadTable();
});
</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title">Jadwal Tes / Wawancara</div>
			<div class="app_link">			
				<a class="add btn btn-primary" href="?app=test&act=add" title=""><i class="icon-plus"></i> Tambah Jadwal</a>
				<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
				<?php printAlert(); ?>
			</div>
		</div>		 
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th style="width:2% !important;" class="no" colspan="0" id="ck">
				<input type="checkbox" id="checkall" target="check[]"></th>
				<th style="width:20% !important;" hidden-xs><?php echo Title; ?></th>
				<th style="width:10% !important;" class='hidden-xs'>Tanggal</th>
				<th style="width:20% !important; text-align:center;" class='hidden-xs'>Lokasi</th>
				<th style="width:10% !important; text-align:center;" class='hidden-xs'>Jumlah Peserta</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$tb1 = FDBPrefix.'test';
			$sql = DB::table($tb1)->select('*')->orderBy('`tanggal` DESC')->get();
				
			$no=1;
			foreach($sql as $row){			
				
				//test name
				$name = "<a href='?app=test&act=edit&id=$row[id]' class='tips' data-placement='right' title='".Edit."'>$row[judul]</a>";
				
				//checkbox
				$check = "<input type='checkbox' name='check[]' value='$row[id]' rel='ck'>";						
				//creat user group values	
				if(empty($level)) $level = _Public;
				
				echo "<tr><td align='center'>$check</td><td>$name</td><td>$row[tanggal]</td><td align='center' class='hidden-xs'>$row[lokasi]</td><td align='center' class='hidden-xs'>$row[id]</td></tr>";
				$no++;	
			}
			?>
        </tbody>			
	</table>
</form>

<script type="text/javascript">
$(document).ready(function() {	
	CKEDITOR.replace( 'editor', {
		toolbar : 'Null',
	});
});
</script>	
<div style="display: none;">
	<div id="editor" style="display: none;"></div>
</div>