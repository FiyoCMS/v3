<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$row = Database::table($app['table'])->
	where("id=".Input::get('id'))->
	get()[0];
	
echo Form::model($row, ['url' => '', 'method' => 'post']);
?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
		<div class="app_title"><?php echo Edit_Article; ?></div>		
			<div class="app_link">	
				<a class="btn btn-default" href="?app=article" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>

				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="edit"><i class="icon-check"></i> <?php echo Save; ?></button>
				
				<button type="submit" class="btn btn-default hidden-xs" title="<?php echo Save_and_Quit; ?>" value="<?php echo Save_and_Quit; ?>" name="edit_quit"><i class="icon-check-circle"></i> <?php echo Save_and_Quit; ?></button>
				<button type="submit" class="btn btn-default btn-grad hidden-xs" title="<?php echo Save_add_new; ?>" value="<?php echo Save_add_new; ?>" name="edit_new"><i class="icon-check-circle"></i> <?php echo Save_Add_New; ?></button>		
				
				<?php printAlert(); ?>
			</div>
		</div>
	</div>	
	<?php 
		require('field_article.php');
	?>		
</form>		