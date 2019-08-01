<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


defined('_FINDEX_') or die('Access Denied');


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
$article = $row['text'];
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
});
</script>		
<div id="article">
<div class="col-lg-9 box-left">
	<div class="box article-editor">								
		<div>
				<?php
					echo Form::text(
						'name', 
						'', 
						["class" => "title", "required","placeholder" =>Enter_title_here]
					);
				?>
		</div>
		<div style="padding:10px 0 0; overflow: hidden;">
			<div class="load-editor">

				<?php
					if(checkLocalhost()) {
						$article = str_replace("media/",FLocal."media/",html_entity_decode($row['text'],ENT_NOQUOTES));			
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
				<td class="model-title">Line Type</td>
				<td>
				<?php						
						$sel = [
							0 => "No Line",
							1 => "Style 1",
							2 => "Style 2",
							3 => "Style 3"
						];
							
						echo Form::select(
							'line',$sel, 
							["class" => "form-control deselect","required"]
						);
					
					?>
				</td>
			</tr>
		</table>
  </div>
 </div>

