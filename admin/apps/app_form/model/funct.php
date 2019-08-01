<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

/****************************************/
/*				 Sub Menu 				*/
/****************************************/ 			
function sub_menu($parent_id,$pre,$nos) {
	$tb1 = FDBPrefix.'menu';
	$tb2 = FDBPrefix.'user_group';	
	$sql = DB::table($tb1)
		->select("$tb1.id,category,name,parent_id,status,short,
			$tb1.level,home,title,show_title,group_name,layout,app")
		->where("parent_id=$parent_id")
		->orderBy("short ASC")
		->leftJoin($tb2,"$tb2.level= $tb1.level")
		->get();
		
	$no=1;
	foreach($sql as $row){
		/* logika status aktif atau tidak */
		$sts = "<span style='display:none'>disable</span>";
		if($row['status']==1)
			{ $stat1 ="selected"; $stat2 =""; $sts = "<span style='display:none'>enable</span>";}							
		else
			{ $stat2 ="selected";$stat1 ="";}	

		$status ="
		<p class='switch'>
			<label class='cb-enable $stat1'><span>On</span></label>
			<label class='cb-disable $stat2'><span>Off</span></label>
			<input type='text' value='$row[id]' id='id' class='invisible'><input type='text' value='$row[status]' id='type' class='invisible'>
		</p>";												
							
		$name = "<a class='tips' title='".Edit."' data-placement='right' href='?app=menu&act=edit&id=$row[id]'>$pre|_ $row[name]</a>";
							
		$checkbox = "<input type='checkbox' name='check[]' value='$row[id]' rel='ck'  data-parent='$parent_id'>";
					

		if($row['status']==1)
			{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
			else
			{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
				
		$status ="
				<div class='switch s-icon activator'>
				<label class='cb-enable tips $stat1' data-placement='right' title='".Disable."'><span>
				<i class='icon-remove-sign'></i></span></label>
				<label class='cb-disable tips $stat2' data-placement='right' title='".Enable."'><span>
				<i class='icon-check-circle'></i></span></label>
				<input type='hidden' value='$row[id]' id='id' class='invisible'>
				<input type='hidden' value='$row[status]' id='type' class='invisible'>
			</div>";					
				
				/* change home page */
				if($row['home']==1)
				{ $hm = "selected"; $hms = ""; }							
				else
				{ $hm = ""; $hms = "selected";  }		
				$home ="
				<div class='switch s-icon home'>
					<label class='cb-enable $hm tips' data-placement='left' title='".Set_as_home_page."'>
					<span>
					<i class='icon-home'></i></span></label>
					<label class='cb-disable $hms tips' data-placement='left' title='".As_home_page."'>
					<span>
					<i class='icon-home'></i></span></label>
					<input type='text' value='$row[id]' data-category='$row[category]' id='id' class='invisible'><input type='text' value='stat' id='type' class='invisible'>
				</div>";
				
		/* auto change default page */			
		if($row['layout']==1)
		{ $dm = "selected"; $dms = ""; }							
		else
		{ $dm = ""; $dms = "selected";  }		
		$default ="<div class='switch s-icon star'>
			<label class='cb-enable $dm tips' title='".Set_as_default_page."'><span>
			<i class='icon-star'></i>
			</span></label>
			<label class='cb-disable $dms tips' title='".As_default_page."'><span>
			<i class='icon-star'></i></span></label>
			<input type='text' value='$row[id]'  class='invisible' id='id'><input type='text' value='fp' id='type' class='invisible'>
		</div>";	
				
		if($row['level']==99) {		
			$level = _Public;
		} 
		else 
		{
			$level = $row['group_name']; 
		}
		
		if($row["category"] == "adminpanel") {
			$home = $default = null;
		}
		echo "<tr>";
		echo "<td align='center'>$checkbox</td><td>$name</td><td class='' align='center'><div class='switch-group'>$home$status</div></td><td class='hidden-xs'>$row[category]</td><td class='hidden-xs'>$row[app]</td><td class='hidden-xs hidden-sm' align='center'>$row[short]</td><td align='center' class='hidden-xs'>$level</td><td align='center' class='hidden-xs'>$row[id]</td>";
		echo "</tr>";
		sub_menu($row['id'],$pre."&nbsp;&nbsp;&nbsp;&nbsp;","$nos.$no");
		$no++;	
	}
}
	
/****************************************/
/*		      Option Sub Menu 			*/
/****************************************/ 	
function option_sub_menu($parent_id,$sub = NULL,$pre = null) {
	if($_REQUEST['id']) $eid = "AND id!=$_REQUEST[id]"; else $eid = '';
	$sql = Database::table(FDBPrefix.'menu')
		->where("parent_id = $parent_id")
		->select('id,parent_id, name')->get();
	$row = [];						
	
	foreach($sql as $k=>$v) {
		$row[$v['id']] = $pre.'|_ '.$v['name'];							
		$row += option_sub_menu($v['id'],$v['parent_id'], $pre."__");
	}
	return $row;
}
	