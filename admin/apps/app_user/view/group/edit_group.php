<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if($_SESSION['USER_LEVEL'] > 2){
	alert('info','Redirecting...');
	alert('loading');
	redirect('?app=user&view=group');
}

$sql= DB::table(FDBPrefix.'user_group')->orderBy('level ASC')->where("id=$_REQUEST[id]")->get(); 
$qr = $sql[0]; 
if(!$qr) redirect('?app=user&view=group');
if($qr['id']==1 or $qr['id']==2 or $qr['id']==3 or $qr['level']==1 or $qr['level']==2 or $qr['level']==3) {$dis="readonly"; $dis2 = ""; }
else {$dis =  null; $dis2 = "spinner";}

?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title">User Group</div>
			<div class="app_link">
				<a class="btn btn-default" href="?app=user&view=group" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> <?php echo Back; ?></a>
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="Next" name="edit_group"><i class="icon-check"></i> <?php echo Save; ?></button>				
				</button>	
				<?php printAlert(); ?>
			</div>	
		</div>
	</div>
	<div class="panel box">						
		<header>
			<h5>User Group</h5>
		</header>								
		<div>
			<table class="data2">
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_name; ?>">Group Name *</span></td>
				<td>	<input type="hidden" name="id" value="<?php  echo $qr['id'] ?>"><input type="text" name="group_name" size="20" <?php echo "value='$qr[group_name]' $dis" ?> required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_level; ?>">Level *</span></td>
					<td><input class="numeric <?php echo "$dis2" ;?>" type="text" id="level" name="level" size="1" min="1" max="98" <?php echo "value='$qr[level]' $dis" ;?> required>
					
					<input class="numeric" type="hidden"name="levels" <?php echo "value='$qr[level]'" ;?>></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_description; ?>">Description</span></td>
				<td>	<input type="text" name="description" size="50" value="<?php echo $qr['description'];?>"></td>
				</tr>			
			</table>
        </div> 
	</div>
</form>	
