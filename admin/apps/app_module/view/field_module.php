<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$act = $_REQUEST['act'];

//set request id 
if(isset($_REQUEST['id']))
	$id=$_REQUEST['id'];
else 
	$id = null;
	
if(!isset($id)) {
	$_REQUEST['id'] = $id = 0;	
	$name = $_POST['folder'];
	$css_class = null;
	$css_style = null;
	$row = null;
}
else {
	$name = $row['folder'];
	$css_class = $row['class'];
	$css_style = $row['style'];
}	


@include ("../modules/$name/mod_details.php");
$params = "../modules/$name/mod_params.php";
$editor = "../modules/$name/mod_editor.php";

//variabel module parameter
$param = $modParam = $row['parameter'];
define('modParam',$row['parameter']);

if(!isset($module_name)) $module_name = "$name";
?>
<script>  
$(function() {
	$.ajax({
        url: "?app=module&api=spot_position",
        success: function( data ) {
            var availableTags = data.split(",");
			$( "#position" ).autocomplete({
			  source: availableTags,
				minLength: 0,
			});
        }
    });	
	
	

	$("form#mainForm").submit(function (e) {
		/*static event*/
		e.preventDefault();

		/* initialize editor */
		$("textarea[name='editor']").val(getEditor('editor'));		
		
		/* get Form data */
		data = $(this).serialize();

		
		/* send post data */
		$.post("?app=module&api=save", data).done(function (result) {
			notice(result);		
		});
	});


	$(".popup").click(function(){		
		$("#iframe").contents().find("a").click(function(e){			
			e.preventDefault();
		});
		$("#iframe").contents().find(".theme-module").click(function(){
			$('#position').val($(this).html());
			$('#spotPosition').modal('hide');
		});
		$("#iframe").contents().find("*").click(function(){
			$("#iframe").contents().find('embed').remove();
		});
		$("#iframe").contents().find('embed').remove();
	});
  });
</script>
<div class="col-lg-6 box-left">
	<div class="box">								
		<header class="dark">
			<h5>Module Details</h5>
		</header>								
		<div>
			<table class="data2">
			<tr>
				<td class="row-title"><span class="tips" title="<?php echo Module_Type_tip; ?>"><?php echo Module_Type; ?></span></td>
				<td><b><i><?php echo $name; if(isset($row)) echo " (id = $row[id])";?></i></b>
					<input type="hidden" name="mod_id" class="menuid" value="<?php echo $row['id'];?>">
					<?php
						echo Form::hidden(
							'folder',$name
						);
					?>
					</td>
			</tr>
			<tr>
					<td><?php echo Name; ?></td>
					<td>					
					<?php
						echo Form::text(
							'name', 
							'', 
							["class" => "form-control ", "required","style" => "min-width: 60%"]
						);
					?>
					</td>
				</tr>
			<tr>
				<td class="row-title"><span class="tips" title="<?php echo Module_Show_Title_tip; ?>"><?php echo Module_Show_Title; ?></span></td>
				<td>
					<?php 
					if($row['show_title'] or $act == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="radio1"  value="1" name="show_title" type="radio" <?php echo $f1;?> class="invisible">
						<input id="radio2"  value="0" name="show_title" type="radio" <?php echo $f0;?> class="invisible">
						<label for="radio1" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="radio2" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			<tr>
				<td class="row-title"><span class="tips" title="<?php echo Module_Status_tip; ?>"><?php echo Active_Status; ?></span></td>
				<td><?php 
					if($row['status'] or $act == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="radio3"  value="1" name="status" type="radio" <?php echo $f1;?> class="invisible">
						<input id="radio4"  value="0" name="status" type="radio" <?php echo $f0;?> class="invisible">
						<label for="radio3" class="cb-enable <?php echo $f1;?>"><span>On</span></label>
						<label for="radio4" class="cb-disable <?php echo $f0;?>"><span>Off</span></label>
					</p></td>
			</tr>
			<tr>
				<td class="row-title"><span class="tips" title="<?php echo Module_Position_tip; ?>"><?php echo Position; ?></span></td>
				<td>
				<div class="input-append date input-group" style="  width: 160px;">
					<input type="text" value="<?php echo $row['position'] ; ?>" type="text" size="20" name="position" id="position" required class="form-control" style="border-radius: 3px 0 0 3px;">
					<span class="add-on input-group-addon">
					<a class="popup icon-magic tips" data-toggle="modal" href="#spotPosition" rel="width:940;height:400" title="<?php echo Select_position; ?>"></a>
					</span>
				 </div>
				 
				</td>
			</tr>
			<tr>
				<td class="row-title"><span class="tips" title="<?php echo Module_Order_tip; ?>"><?php echo Module_Order; ?></span></td>
				<td><input value="<?php echo $row['short'] ; ?>" type="number" name="short" size="5" id="order" class="numeric spinner" style="width: 50px"  min="0"></td>
			</tr>
			<tr>
				<td class="model-title"><span class="tips" title="<?php echo Access_Menu_tip; ?>"><?php echo Access_Level ?></span></td>
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
				<td class="model-title"><span class="tips" title="<?php echo Access_Menu_tip; ?>">Layout</span></td>
				<td>
					<?php
						$sql = Database::table(FDBPrefix.'theme_layout')
								->select('id, name')->get();
						$qr = [];
						foreach($sql as $k=>$v) {
							$qr[$v['id']] = $v['name'];				
						}
						
						echo Form::select(
							'page[]',$qr, explode(',', $row['page']),
							["class" => "form-control", "required", 'multiple' => 'multiple', 'style'=> 'min-width: 60%']
						);
					?>
				</td>
			</tr>
			
			</table>
		</div>
	</div>	
</div>	

<div class="panel-group box-right" id="accordion">
	<?php 
		if(file_exists($params)) {			
			$modParam = $param = $row['parameter'];
			require($params);
		}
		else $open =' open';
	?>
	<div class="panel box">								
		<header>
			<a class="accordion-toggle <?php if(file_exists($params)) echo "collapsed"; ?>" data-toggle="collapse" href="#menu-style" data-parent="#accordion">
				<h5>Module Styling</h5>
			</a>
		</header>	
		<div id="menu-style" class="<?php if(file_exists($params)) echo "collapse"; else echo "in"; ?>">
			<table>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Add_css_class_tip; ?>">CSS Class</span></td>
					<td><input value="<?php echo $css_class ; ?>" type="text" name="class" style="width: 60%;"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Add_css_style_tip; ?>">CSS Style</span></td>
					<td><textarea type="text" name="style" rows="5" style="width: 90%; resize: vertical;"><?php echo $css_style; ?></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>



<!-- #helpModal -->        
<div id="spotPosition" class="modal fade bs-example-modal-lg">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title"><?php echo Module_Position; ?></h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      </div>
			<div id="pages" class="pop_up">
				<div id="page_id">
					<iframe id="iframe" frameborder="0" src="<?php echo FUrl."?app=null&theme=module"; ?>" style="height:530px;width:100%; margin-bottom: -5px;"></iframe>
				</div>
			</div>
	    </div>
	</div>
</div>
