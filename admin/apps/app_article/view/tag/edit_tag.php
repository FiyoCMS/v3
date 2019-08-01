<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


$row = Database::table(FDBPrefix.'article_tags')->
	where("id=".Input::get('id'))->
	get()[0];
	
echo Form::model($row, ['url' => '', 'method' => 'post']);

?>

<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Edit_Tag; ?></div>
			<div class="app_link">	
				<a class="btn btn-default" href="?app=article&view=tag" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="tag_edit"><i class="icon-check"></i> <?php echo Save; ?></button>				
				<?php printAlert(); ?>
			</div>			
		</div>
	</div>	   	
	<div class="panel box"> 		
		<header>
			<h5>Umum</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title"><?php echo Tag_Title; ?></td>
					<td><input type="hidden" name="id" value="<?php  echo $row['id'] ?>">
					<?php 
							echo Form::text(
							'name','',
							["class" => "form-control","required"]
						);
						?></td>
				</tr>
				<tr>
					<td class="row-title"><?php echo Tag_Desc; ?></td>
					<td><?php 
							echo Form::textarea(
							'description','',
							["class" => "form-control","rows" =>4 ,"cols" => 50]
						);
						?></td>
				</tr>
			</table>
		</div> 
    </div> 
</form>	

