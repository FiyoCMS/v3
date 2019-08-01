<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$row = Database::table(FDBPrefix.'module')->
	where("id=".Input::get('id'))->
	get()[0];
	
echo Form::model($row, ['url' => '', 'method' => 'post', 'id' => 'mainForm']);
?>

	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Edit_Module; ?></div>			
			<div class="app_link">	
				<a class=" btn btn-default" href="?app=module" title="<?php echo Cancel; ?>">				
				<i class="icon-arrow-left"></i> </a>			
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="edit"><i class="icon-check"></i> <?php echo Save; ?></button>		
			</div>
			<?php printAlert(); ?>
		</div>			 
	</div>
		
	<?php 
		require('field_module.php');
	?>	
</form>
