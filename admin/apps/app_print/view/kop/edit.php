<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$row = Database::table(FDBPrefix."reports_kop")->
	where("kop_id=".Input::get('id'))->
	get()[0];
	
echo Form::model($row, ['url' => '', 'method' => 'post']);
?>

	<div id="app_header">
		<div class="warp_app_header">		
		<div class="app_title">Edit Page</div>		
			<div class="app_link">	
				<a class="btn btn-default" href="?app=<?php echo $app['root']; ?>&view=kop" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>

				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="edit_kop"><i class="icon-check"></i> <?php echo Save; ?></button>
				
				
				<?php printAlert(); ?>
			</div>
		</div>
	</div>	
	<?php 
		require('field.php');
	?>		
</form>		