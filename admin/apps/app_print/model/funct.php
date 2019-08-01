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
function option_sub_cat($parent_id,$sub = NULL,$pre = null) {
	$id = Input::get('id');
	if($id ) $eid = "AND id!=$id"; else $eid = '';
	$sql = Database::table(FDBPrefix.'article_category')
		->where("parent_id = $parent_id")
		->select('id, name, level')->get();
	$row = [];						
	
	foreach($sql as $k=>$v) {
		if($v['level'] >= $_SESSION['USER_LEVEL'])
		$row[$v['id']] = $pre.'|_ '.$v['name'];							
		$row += option_sub_cat($v['id'],$v['name'], $pre."__");
	}
	return $row;
}
					



/****************************************/
/*	 	   Sub Article Category			*/
/****************************************/ 
// membuat fungsi sub-article yang akan di tampilkan dibawah parent_id	
function sub_article($parent_id,$nos,$pre = null) {
	$tb1 = FDBPrefix.'article_category';
	$tb2 = FDBPrefix.'user_group';	
	$sql = DB::table($tb1)
		->select("$tb1.id,name,parent_id,$tb1.description, $tb1.level, group_name")
		->where("parent_id=$parent_id")
		->leftJoin($tb2,"$tb2.level= $tb1.level")
		->get();				
	$no = 1; 
	
	foreach($sql as $qr) {	
		$sum = DB::table(FDBPrefix.'article')
			->select('COUNT(*) AS count')
			->where('category='.$qr['id']) -> get()[0]['count']; 
			
		if($qr['level']==99) 
				$level = _Public;				
			else {						
				$level = $row['group_name'];
			}			
				
		if($qr['level'] >= $_SESSION['USER_LEVEL'] ) {
			$checkbox ="<input type='checkbox' data-name='rad-$qr[id]' name='check_category[]' value='$qr[id]' rel='ck'>";	
			
			$name ="<a class='tips' data-placement='right'  title='".Edit."' href='?app=article&view=category&act=edit&id=$qr[id]'>$qr[name]</a>";
			}
		else {
			$checkbox ="<span class='icon lock'></lock>";
			$name ="$qr[name]";
		}
			
		echo "<tr>";
		echo "<td align='center'>$checkbox</td><td>$pre|_ $name <span class='label label-primary right visible-xs'>$sum</span></td><td align='center'  class='hidden-xs'>$level</td><td align='center'  class='hidden-xs'>$sum</td>";
		echo "</tr>";
		sub_article($qr['id'],"$nos.$no",$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		$no++;	
	}			
}

/****************************************/
/*		Sub Option (Admin Panel)		*/
/****************************************/ 	
function option_subs_cat($parent_id,$pre) {
		$tb1 = FDBPrefix.'article_category';
			$tb2 = FDBPrefix.'user_group';	
			$sql = DB::table($tb1)
				->select("$tb1.id,name,parent_id,$tb1.description, $tb1.level, group_name")
				->where("parent_id=$parent_id")
				->leftJoin($tb2,"$tb2.level= $tb1.level")
				->get();			
			$no = 1; 
			foreach($sql as $row){				
				$jml = DB::table(FDBPrefix.'article')
					->select('COUNT(*) AS count')
					->where('category='.$row['id']) -> get()[0]['count']; 

				//creat user group values	
				if($row['level']==99) 
					$level = _Public;				
				else {						
					$level = $row['group_name'];
				}					
								
				if($_SESSION['USER_LEVEL'] <= $row['level']) {
					$name = "<a class='tips' data-placement='right' title='".Edit."' href='?app=article&view=category&act=edit&id=$row[id]'>$row[name]</a> ";
					$checkbox ="<input type='checkbox' data-name='rad-$row[id]' name='check_category[]' value='$row[id]' rel='ck'>";
				}
				else {
					$checkbox ="<span class='icon lock'></lock>";
					$name = "$row[name]";
				}
				
				$name = "<option value='$row[id]' $s>$pre |_ $name</option>";
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name <span class='label label-primary right visible-xs'>$jml</span></td><td align='center' class='hidden-xs'>$level</td><td align='center' class='hidden-xs'>$jml</td>";
				echo"</tr>";
				option_sub_cat($row['id'],"<span style='display: none'>$name</span>" );
				$no++;	
			}	
				
				
	if(!isset($_REQUEST['id']) or $_REQUEST['act'] == 'add') 
		$sql = DB::table(FDBPrefix."article_category")->where("parent_id=$parent_id")->get(); 
	else
		$sql = DB::table(FDBPrefix."article_category")->where("parent_id=$parent_id AND id != $_REQUEST[id]")->get(); 
	foreach($sql as $qr){
		if($qr['level'] >= $_SESSION['USER_LEVEL'] ){		
			$scat = $pcat = 0;			
			if(isset($_REQUEST['id'])) {
				$scat = oneQuery('article','id',$_REQUEST['id'],'category');
				$pcat = oneQuery('article_category','id',$scat,'parent_id');
			}			
			if($pcat == $qr['id'] or $scat == $qr['id']) $s ="selected"; else $s="";
			echo "<option value='$qr[id]' $s>$pre|_ $qr[name]</option>";
			option_sub_cat($qr['id'],$pre."&nbsp;&nbsp;&nbsp;&nbsp;");
		}
	}		
}
