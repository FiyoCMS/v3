<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2018 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_Category; ?></div>
			<div class="app_link">
				<a class="btn btn-default" href="?app=menu&view=category" title="<?php echo Cancel; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>
				<button class="btn save" title="<?php echo Save; ?>" name="add_category" type="submit" value="Save" ><?php echo Save; ?></button>
			</div><?php printAlert(); ?>
		</div>
	</div> 
 	
	<div class="col-lg-12">
		<div class="box">								
			<header class="dark">
				<h5>Menu Details</h5>
			</header>								
			<div>	
				<table>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Category_Title_tip; ?>"><?php echo Category_Title; ?></span></td>
						<td>
					<?php
						echo Form::hidden(
							'id', 
							'', 
							["class" => "form-control",'style'=> 'width: 40px', "","min" => 0]
						);
						echo Form::text(
							'title', 
							'', 
							["class" => "form-control",'style'=> '', "required","size" => 20]
						);
					?></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Category_Name_tip; ?>"><?php echo Category_Name; ?></span></td>
						<td>
					<?php
						echo Form::text(
							'category', 
							'', 
							["class" => "form-control alphanumeric nospace",'style'=> '', "required","size" => 20]
						);

						echo Form::hidden(
							'cats', 
							'', 
							["class" => "form-control",'style'=> 'width: 40px', "required","min" => 0]
						);
					?></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Category_level; ?>"><?php echo Access_Level; ?></span></td>
						<td><?php
						$sql = Database::table(FDBPrefix.'user_group')
								->select('level, group_name')->get();
								
						$row = [99 => _Public];
						foreach($sql as $k=>$v) {
							$row[$v['level']] = $v['group_name'];				
						}
						echo Form::select(
							'level',$row, '',
							["class" => "form-control", "required"]
						);
					?>
					</td>
				</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Description; ?>"><?php echo Description; ?></span></td>
						<td><?php
						echo Form::text(
							'description', 
							'', 
							["class" => "form-control alphanumeric nospace",'style'=> ' min-width: 60%; max-width:100%;', "required","size" => 20]
						);

						
					?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</form>	
