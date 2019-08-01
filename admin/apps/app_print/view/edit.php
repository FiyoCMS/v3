<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$row = Database::table($app['table'])->
	where("$app[index]=".Input::get('id'))->
	get()[0];
	
echo Form::model($row, ['url' => '', 'method' => 'post']);
?>
	<div id="app_header">
		<div class="warp_app_header">		
		<div class="app_title">Edit Page</div>		
			<div class="app_link">	
				<a class="btn btn-default" href="?app=<?php echo $app['root']; ?>" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>

				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="edit"><i class="icon-check"></i> <?php echo Save; ?></button>
				
				<a type="submit" class="btn btn-default" target="_blank" href="<?php echo url("?app={app}&print=preview&page=$row[name]")?>" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="edit"><i class="icon-search"></i> Preview <?php echo _Print; ?></a>
				
				<?php printAlert(); ?>
			</div>
		</div>
	</div>	
	<?php 
		require('form.php');
	?>		
</form>		