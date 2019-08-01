<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$row = Database::table(FDBPrefix.'article_category')->
	where("id=".Input::get('id'))->
	get()[0];
	
echo Form::model($row, ['url' => '', 'method' => 'post']);
?>
<script>
$(function() {
	$(".parent").chosen({disable_search_threshold: 10, 
	allow_single_deselect: true});
});
</script>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo New_Category; ?></div>
			<div class="app_link">	
			<a class="btn btn-default" href="?app=article&view=category" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>
				
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_category"><i class="icon-check"></i> <?php echo Save; ?></button>			
			<?php printAlert(); ?>
			</div>			
		</div>
	</div>	   	
	<div class="panel box"> 		
		<header>
			<h5><?php echo Article_category; ?></h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Category_Name; ?>"><?php echo Category_Name; ?></span></td><td>
					<?php 
					
						echo Form::text(
							'name','',
							["class" => "form-control level filter","required"]
						);
						?></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Parent_category_tip; ?>"><?php echo Parent_category; ?></span></td>
					<td>
					
					<?php						
						$sql = Database::table(FDBPrefix.'article_category')
								->select('id, name, level')->where('parent_id = 0');
								
						$sql = $sql->orderBy('name ASC')->get();

							$sel = ["" => " "];
							
						foreach($sql as $k=>$v) {
							if($v['level'] >= $_SESSION['USER_LEVEL'])
							$sel[$v['id']] = $v['name'];							
							$sel += option_sub_cat($v['id'],$v['name']);
						}
						echo Form::select(
							'parent_id',$sel, '',
							["class" => "form-control parent parents deselect",""]
						);
					
					?>
					
					
					</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Category_level; ?>"><?php echo Access_Level; ?></span></td>
					<td><?php
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
					<td class="row-title"><span class="tips" title="<?php echo Description; ?>"><?php echo Description; ?></span></td>
					<td><?php 
					
						echo Form::textarea(
							'description','',
							["class" => "form-control level filter","rows" => 5, "cols" => 50]
						);
						?></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Keyword; ?>"><?php echo Keyword; ?></span></td>
					<td><?php
						echo Form::textarea(
							'keywords','',
							["class" => "form-control level filter","rows" => 5, "cols" => 50]
						);
						?></td>
				</tr>
			</table>
        </div> 
	  </div>
	</div>
</form>	
