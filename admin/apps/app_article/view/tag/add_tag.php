<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo New_Tag; ?></div>
			<div class="app_link">
				<a class="btn btn-default" href="?app=article&view=tag" title="<?php echo Prev; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="tag_add"><i class="icon-check"></i> <?php echo Save; ?></button>	
				</div>	<?php printAlert(); ?>		
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
					<td><input type="hidden" name="id" value=""><input type="text" name="name" size="30" <?php formRefill('name'); ?> required></td>
				</tr>
				<tr>
					<td class="row-title"><?php echo Tag_Desc; ?></td>
					<td><textarea type="hidden" name="desc" rows="4" cols="50"><?php formRefill('desc','','textarea'); ?></textarea></td>
				</tr>
			</table>
		</div> 
    </div> 
</form>	
