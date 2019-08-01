<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


//set request id 
$id= Input::get('id');
$menuLink = null;

$act = Input::get('act');
switch($act)
{
	case 'add':
		$name = $_POST['apps'];		
		$model = null;
		$mod_class = null;
		$mod_style = null;
		$show_title = null;
		if($name == 'sperator')
		$menuLink = '#';
		$edit = 0;
	break;
	
	case 'edit':
		$name = $model['app'];
		$param = $model['parameter'];
		$mod_class = $model['class'];
		$mod_style = $model['style'];
		$show_title = $model['show_title'];
		$menuLink = $model['link'];
	break;
}
?>
 
<script type="text/javascript">
$(function() {
	function lockLayout() {
		var cat = $('.categorymenu').val();
		if(cat == 'adminpanel') {
			$('.layout').removeAttr('required').removeClass('required');
			$('.layout + div + div').hide();
		} else {
			
			$('.layout').attr('required','required').addClass('required');
			$('.layout + div + div').css('display','inline-block');
		}
		
	}
	lockLayout();
	$(".categorymenu").change(function(){
		var cat = $('.categorymenu').val();	
		var id = $('.menuid').val();	
		var pid = $('.parentid').val();	
		lockLayout();
		$.ajax({
			type: "POST",
			url: "?app=menu&api=parent",
			data: "id="+id+"&cat="+cat+"&parent="+pid,
			success: function(data){
				console.log(data);
				$(".parent").html(data);
				$(".parent").next().css({ "min-width": "50%", "max-width": "100%" });
				$(".parent").trigger("chosen:updated");
			}
		});		
	});

	<?php if($act == 'add') : ?>
	$(".parent").next().css({ "min-width": "50%", "max-width": "100%" });
	<?php endif; ?>

	$(".parent").chosen({disable_search_threshold: 10, 
	allow_single_deselect: true});
});
</script>
<div class="col-lg-6 box-left">
	<div class="box">								
		<header class="dark">
			<h5>Menu Details</h5>
		</header>								
		<div>
			<table>
				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Menu_Type_tip; ?>"><?php echo Menu_Type; ?></span></td>
					<td><b><i><?php echo $name; if(isset($model)) echo " (id = $model[id])";?></i></b>
					<?php
						if($act == 'add') $app = Input::post('apps'); 
						else $app = $model['app'];
						echo Form::hidden(
							'apps', 
							$app, 
							["class" => "form-control numeric"]
						);
					?>
					<input type="hidden" name="id" class="menuid" value="<?php echo $model['id'];?>"></td>
					<input type="hidden" name="parent_id" class="parentid" value="<?php echo $model['id'];?>"></td>
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
					<td>Link</td>
					<td>
					<?php
						$rd = null; 
						if($name !== 'link') {
							$rd = 'readonly';
							$vl = '#';
						} else {
							$rd = '';
							$vl = '';

						}
						echo Form::text(
							'link', 
							$vl, 
							["class" => "form-control", 'id'=> 'link', "required","style" => "min-width: 90%" , $rd]
						);
					?>
					</td>
				</tr>	

				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Menu_Status_tip; ?>"><?php echo Active_Status; ?></span></td>
					<td>					
						<?php 
						echo Form::radio(
							'status','1','','','Enable'
						);

						echo Form::radio(
							'status','0','','','Disable'
						);
						?></td>
				</tr>
				
				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Menu_Category_tip; ?>"><?php echo Menu_Category; ?></span></td>
					<td>
					<?php
						$proyek = Database::table(FDBPrefix.'menu_category')
								->select('title,category')
								->get();
								
						if($act == 'add') 
							$sel = ["" =>""];
						else
							$sel = [];

						foreach($proyek as $k=>$v) {
							$sel[$v['category']] = $v['title'];
						}
						
						echo Form::select(
							'category',$sel, '',
							["class" => "form-control categorymenu", "required"]
						);
					
					?></td>
				</tr>
				<tr>
					<td><?php echo Menu_Order; ?></td>
					<td>
					
					<?php
						echo Form::text(
							'short', 
							'', 
							["class" => "form-control numeric spinner min-0",'style'=> 'width: 40px', "min" => 0]
						);
					?></td>
				</tr>				
				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Parent_Menu_tip; ?>"><?php echo Parent_Menu; ?></span></td>
					<td>
					<?php
						$sql = Database::table(FDBPrefix.'menu')
								->select('id,parent_id, name');


						if($act == 'edit')  {
							$eid = "AND id!=$model[id]";
							$sql->where("parent_id = 0 $eid AND category = '$model[category]'");
						} else {
							$eid = "";
							$sql->where("parent_id = 0 ");
						}
						$sql = $sql->orderBy('short ASC')->get();
						$row = ["" =>""];
									
						foreach($sql as $k=>$v) {
							$row[$v['id']] = $v['name'];							
							$row += option_sub_menu($v['id'],$v['parent_id']);
						}
													
						echo Form::select(
							'parent_id',$row, '',
							["class" => "form-control parent deselect"]
						);
					
					?>
					
					</select></td>
				</tr>
				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Access_Menu_tip; ?>"><?php echo Access_Level ?></span></td>
					<td>
						<?php
							$sql = Database::table(FDBPrefix.'user_group')
									->select('level, group_name')->get();
									
							$row = [];
							foreach($sql as $k=>$v) {
								$row[$v['level']] = $v['group_name'];				
							}
							$row += [99 => _Public];
							if(empty($row['level'])) $level = 99;
							else $level = null;
							echo Form::select(
								'level',$row, $level,
								["class" => "form-control", "required"]
							);
						?>
					</td>
				</tr>
				<tr>
					<td>Layout Menu</td>
					<td>
					<?php						
						$sql = Database::table(FDBPrefix.'theme_layout')
								->select('id, name')->get();
								
						$row = [];
						if($sql)
						foreach($sql as $k=>$v) {
							$row[$v['id']] = $v['name'];				
						}
						echo Form::select(
							'layout',$row, 
							["class" => "form-control", "required","data-placeholder" => Choose_tags]
						);
					?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="col-lg-6 box-right">
	<?php 
		$menuParam = $model['parameter'];
		$params = "apps/$name/preset.php";	

		$menuId = $asset = $id ;
		define('menuParam',$menuId);
		
		$hidden = '';
		if($name == 'link' or $name == 'sperator') $hidden = 'hidden';
		


	if(file_exists($params)) include_once($params);
	?>
	<div class="box <?php echo $hidden;?>">								
		<header>
			<a class="accordion-toggle <?php if(file_exists($params)) echo "collapsed"; ?>" data-toggle="collapse" href="#page-configuration">
				<h5>Page Configuration</h5>
			</a>
		</header>								
		<div id="page-configuration" class="<?php if(file_exists($params)) echo "collapse"; else echo "in"; ?>">
			<table>
				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Page_Title_tip; ?>"><?php echo Page_Title; ?></span></td>
					<td><input value="<?php echo $model['title'] ; ?>" type="text" name="title" style="width: 70%;"></td>
				</tr>
				<tr>
					<td class="model-title"><span class="tips" title="<?php echo Show_title_tip; ?>" ><?php echo Show_title; ?></span></td>
					<td>
						<?php 
							if($show_title or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
							else {$s0="selected checked"; $s1= "";}
						?>
						<p class="switch">
							<input id="radio3" value="1" name="show_title" type="radio" <?php echo $s1;?> class="invisible">
							<input id="radio4" value="0" name="show_title" type="radio" <?php echo $s0;?> class="invisible">
							<label for="radio3" class="cb-enable <?php echo $s1;?>"><span>Yes</span></label>
							<label for="radio4" class="cb-disable <?php echo $s0;?>"><span>No</span></label>
						</p>
					</td>
				</tr>							
			</table>
		</div>
	</div>
	
	<div class="box">								
		<header>
			<a class="accordion-toggle <?php if(file_exists($params)) echo "collapsed"; ?>" data-toggle="collapse" href="#menu-style">
				<h5>Menu Styling</h5>
			</a>
		</header>	
		<div id="menu-style" class="<?php if(file_exists($params)) echo "collapse"; else echo "in"; ?>">
			<table>
				<tr>
					<td class="model-title"><span class="tips"  title="<?php echo Subtitle_tip; ?>"><?php echo Subtitle_Menu; ?></span></td>
					<td><input value="<?php echo $model['sub_name'] ; ?>" type="text" name="sub_name" style="width: 60%;"></td>
				</tr>
				<tr>
					<td class="model-title"><span class="tips"  title="<?php echo Add_css_class_tip; ?>">CSS Class</span></td>
					<td><input value="<?php echo $mod_class ; ?>" type="text" name="class" style="width: 60%;"></td>
				</tr>
				<tr>
					<td class="model-title"><span class="tips"  title="<?php echo Add_css_style_tip; ?>">CSS Style</span></td>
					<td><textarea type="text" name="style" models="5" style="width: 90%; resize: vertical;"><?php echo $mod_style ; ?></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>