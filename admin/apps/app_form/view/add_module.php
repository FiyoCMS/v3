<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

echo Form::open(['url' => '', 'method' => 'post']);

?>
<div id="app_header">
	<div class="warp_app_header">
		<div class="app_title">Tambah Tes / Wawancara</div>
		<div class="app_link">
			<a class="btn btn-default" href="?app=test" title="<?php echo Back; ?>"> <i class="icon-arrow-left"></i> </a>			
			<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="Next" name="save"> <i class="icon-check"></i>
				<?php echo Save; ?></button>	
				<?php printAlert(); ?>
		</div>
	</div>			 
</div>
<?php require('field.php'); ?>
