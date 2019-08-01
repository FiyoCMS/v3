<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>
<script>
$(function() {
	$(".parents").chosen({disable_search_threshold: 10, 
	allow_single_deselect: true});
});
</script>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo New_Category; ?></div>
			<div class="app_link">	
				<a class="btn btn-default" href="?app=reports&view=category" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>
				
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="save_category"><i class="icon-check"></i> <?php echo Save; ?></button>				
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
							'cat_name','',
							["class" => "form-control level filter","required"]
						);
						?></td>
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
			</table>
        </div> 
	  </div>
	</div>
</form>	
