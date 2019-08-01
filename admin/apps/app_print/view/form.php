<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die; 

//set GET id 
if(isset($_GET['id']))
	$id=$_GET['id'];
else
	$id = null;
if(!isset($id)) {
	$_GET['id']=0;	
	$row = $editor_level = null;
	$new =1;	
	$show_comment = $panel_top = $show_title = $panel_bottom = $show_author = $show_date = $show_category = $show_hits=$show_tags = $show_rate = 2; 
	$rate_value = $rate_counter = 0;
}
else {

	$show_comment	= mod_param('comment',$row['parameter']);
	$panel_top 		= mod_param('panel_top',$row['parameter']);
	$panel_bottom 	= mod_param('panel_bottom',$row['parameter']);
	$show_author 	= mod_param('show_author',$row['parameter']);
	$show_date  	= mod_param('show_date',$row['parameter']);
	$show_category	= mod_param('show_category',$row['parameter']);
	$show_hits  	= mod_param('show_hits',$row['parameter']);
	$show_tags  	= mod_param('show_tags',$row['parameter']);
	$show_rate	 	= mod_param('show_rate',$row['parameter']);
	$show_title	 	= mod_param('show_title',$row['parameter']);
	$rate_value		= mod_param('rate_value',$row['parameter']);
	$rate_counter 	= mod_param('rate_counter',$row['parameter']);
	$editor_level 	= mod_param('editor_level',$row['parameter']);
}	
$article = $row['main'];
if(checkLocalhost()) {
	$article = str_replace("media/",FLocal."media/",$article);			
}
if(!is_numeric($rate_value) or empty($rate_value)) $rate_value = 0;			
if(!is_numeric($rate_value) or empty($rate_counter)) $rate_counter = 0;	

if(empty($rate_counter)) $rates = $rate_counter = $rate_value = 0;
else if(($rate_value/$rate_counter) >= $rate_counter) $rates = 10;
else $rates = angka2($rate_value/$rate_counter);


if($_GET['id']) :
?>
<?php endif; ?>
<script type="text/javascript">
$(function() {		
	CKEDITOR.replace('editor');	
	$('#datetimepicker').datetimepicker({
		language: 'pt-BR'
	});
	
	$("#datepicker").mask("9999-99-99 99:99:99");
	
	$("#content form").submit(function(e){
		var ff = this;
		var text = CKEDITOR.instances.editor.getData();
		if(text && $("#content form").valid()) {
			$(".inner .alert").remove();
			ff.submit();
		}else if(!text) {
			e.preventDefault();
			noticeabs("<?php echo alert('error',Please_write_some_text); ?>");
			CKEDITOR.instances.editor.focus();
		}
	});
	
	
	$('.chosen-with-drop').hide();
});
</script>	

<div id="article" style="width: 100%">
<div class="col-lg-9 box-left">
	<div class="box article-editor">								
		<div>
				<?php
					echo Form::text(
						'title', 
						'', 
						["class" => "title", "required","placeholder" =>Enter_title_here]
					);
				?>
				<?php
					echo Form::hidden('id', '');
				?>
		</div>
		<div style="padding:10px 0 0; overflow: hidden;">
			<div class="load-editor">

				<?php
					if(checkLocalhost()) {
						$article = str_replace("media/",FLocal."media/",html_entity_decode($row['main'],ENT_NOQUOTES));			
					}
					echo Form::textarea(
						'text', 
						$article, 
						["id" => "editor", "required","placeholder" =>Enter_title_here]
					);
				?>
			</div>					
		</div>
	</div>
</div>
			


<div class="panel-group col-lg-3 box-right article-box" id="accordion">
    <div class="panel box"> 		
		<header>
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
				<h5>Umum</h5>
			</a>
		</header>
		<div id="collapseOne" class="panel-collapse in">
		<table class="data2">				
			<tr>
				<td class="model-title"><span class="tips" title="">Nama unik</td>
				<td>
				<?php				
						echo Form::text(
							'name','',
							["class" => "form-control alphanumeric","required"]
						);
					
					?>
				</td>
			</tr>
			<tr>
				<td class="model-title"><span class="tips" title="<?php echo Parent_Menu_tip; ?>"><?php echo Category; ?></span></td>
				<td>
				<?php						
						$sql = Database::table(FDBPrefix.'print_category')
								->select('cat_id, cat_name, level');
								
						$sql = $sql->orderBy('cat_name ASC')->get();

						if($act == 'add') 
							$sel = ["" =>""];
						else
							$sel = [];
							
						foreach($sql as $k=>$v) {
							if($v['level'] >= $_SESSION['USER_LEVEL'] OR $v['level'] == "" )
							$sel[$v['cat_id']] = $v['cat_name'];							
						}
						echo Form::select(
							'category',$sel, 
							["class" => "form-control parent","required"]
						);
					
					?>
				</td>
			</tr>
					
			<tr>
				<td class="model-title"><span class="tips" title="">Kop Surat</td>
				<td>
				<?php						
						$sql = Database::table(FDBPrefix.'print_kop')
								->select('kop_id, name')
								->orderBy('name ASC')
								->get();

							$sel = ["" =>"Kosong"];

						foreach($sql as $k=>$v) {
							$sel[$v['kop_id']] = $v['name'];							
						}

						echo Form::select(
							'kop',$sel, '',
							["class" => "form-control parent deselect"]
						);
					
					?>	</td>
			</tr>
					
			<tr>
				<td class="row-title" title="<?php echo Article_level_tip; ?>" style="width:30%"><?php echo Access_Level; ?></td>
				<td>
					<?php
						$sql = Database::table(FDBPrefix.'user_group')
								->select('level, group_name')->get();
								
						$qr = [99 => _Public];
								//if($rowg['level']==99 AND !$_GET['level'] == '99') $s="selected"; else $s="";
								//echo "<option value='99' $s>"._Public."</option>"
						foreach($sql as $k=>$v) {
							$qr[$v['level']] = $v['group_name'];				
						}

						echo Form::select(
							'level',$qr, '',
							["class" => "form-control level filter", "name"=>"level"]
						);
					?>
				
				</td>
			</tr>	
			<tr>
				<td class="model-title"><span class="tips" title="">File Referensi</td>
				<td>
				<?php				
						echo Form::text(
							'file_reff','',
							["class" => "form-control"]
						);
					
					?>
				</td>
			</tr>
			<tr>
				<td class="row-title" style="width:30%">Lampiran</td>
				<td>
					<?php
						$sql = DB::table(FDBPrefix.'print_page');

						if(app_param('id'))
							$sql->where('page_id != '.app_param('id'));

						$sql = $sql->get();
						$qr = [];
						foreach($sql as $k=>$v) {
						$qr[$v['name']] = $v['name'];				
						}
								
						echo Form::select(
							'pages[]',$qr, explode(',', $row['pages']),
							["class" => "form-control  w-max",  'multiple' => 'multiple', 'style'=> 'width: 100%']
						);
					?> 				
				</td>
			</tr>	
		</table>
  		</div>
 	</div> 
</div>

<?php

$file = __dir__.'/../../../'.$row['file_reff'];
if(file_exists($file) AND strlen($row['file_reff']) > 0) :
	
define('DONT_PRINT', true);
include($file);

?>

<div class="panel-group col-lg-3 box-right article-box" id="accordion">
    <div class="panel box"> 		
		<header>
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
				<h5>Referensi</h5>
			</a>
		</header>
		<div id="collapseOne" class="panel-collapse in">
		<table class="data2">			
			<?php						
				foreach($kamus as $txt=> $reff) {
						echo "<tr><td></td><td> $txt</td></tr>";
				}
			?>
		</table>
  		</div>
 	</div> 
</div>

<?php endif; ?>


</div>


