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
			<div class="app_title">Dokumen Saya</div>
			<div class="app_link">			
			<a class="add btn btn-primary btn-sm btn-grad" href="?app=efile" title=""><i class="icon-plus"></i> Unggah File</a>
			<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_category"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
			</div>
			<?php printAlert('NOTICE'); ?>
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target='check_category[]'></th>		
				<th style="width:70% !important;">File / Kode</th>	
				<th style="width:15% !important;text-align:center" class='hidden-xs'>Status</th>
				<th style="width:15% !important;text-align:center" class='hidden-xs'>Total <?php echo Article; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php		
			$tb1 = FDBPrefix.'efile_dokumen';
			$tb2 = FDBPrefix.'efile_jenis';
			$sql = DB::table($tb1)
				->leftJoin("$tb2", "$tb1.kode = $tb2.kode")
				->select("*")
				->get();			

			$no = 1; 
			foreach($sql as $row){				
				$jml = DB::table(FDBPrefix.'efile_dokumen')
					->select('COUNT(*) AS count')
					->where('nip='.$row['nip']) -> get()[0]['count']; 

				//creat user group values	
				if($row['status']==1) 
					$level = 'Belum di generate';				
				else {						
					$level = 'Terverifikasi';
				}					
				$file = basename($row['nama_file']);
				$thumb = str_replace('.pdf','',$file."_thumb.jpg");
				$dir = dirname($row['nama_file']);
				$dir = str_replace('../../../../','',$dir);
				$nama = $row['nama_jenis'];
								
				$name = "<a class='tips' data-placement='right' title='".Edit."' href='http://localhost/efile/$dir/$file' target='_blank'>
				<img src='http://localhost/efile/$dir/thumb/$thumb ' width= '140'>
				
				
				$nama ($row[kode])</a>";
				$checkbox ="<input type='checkbox' data-name='rad-$row[id_file]' name='check_category[]' value='$row[id_file]' rel='ck'>";
				
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name <span class='label label-primary right visible-xs'>$jml</span></td><td align='center' class='hidden-xs'>$level</td><td align='center' class='hidden-xs'>$jml</td>";
				echo"</tr>";
				$no++;	
				
			}					
			?>
        </tbody>			
	</table>
</form>