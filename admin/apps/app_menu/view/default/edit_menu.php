<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$model = Database::table(FDBPrefix.'menu')->
	where("id=".Input::get('id'))->
	get()[0];

	
echo Form::model($model, ['url' => '', 'method' => 'post']);

?>
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Edit_Menu; ?></div>			
			<div class="app_link">	
				<a class="btn btn-default" href="?app=menu&cat=<?php echo oneQuery('menu','id',$_GET['id'],'category'); ?>" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>	
				<button type="submit" class="btn btn-success" name="edit" value="true"><i class="icon-check"></i> <?php echo Save; ?></button>						
			</div><?php printAlert(); ?>
		 </div>			 
	</div>
	
		
	<?php 
		require('field_menu.php');
	?>	
</form>