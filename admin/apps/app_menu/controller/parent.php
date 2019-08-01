<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();

define('_FINDEX_','BACK');
require_once ('../../../system/jscore.php');
if(!isset($_SESSION['USER_LEVEL']) OR $_SESSION['USER_LEVEL'] > 2 OR !Input::post('cat')) die ('Accsess Denied!');


/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/
echo "<option value=''></option>";	
echo "<option value='0'>Kosong</option>";	
$sql = DB::table(FDBPrefix.'menu')->select('name, parent_id, id, category')->where("parent_id=0 AND category = '$_POST[cat]' AND id !='$_POST[id]'")->orderBy('short ASC')->get(); 
foreach($sql as $row){	
	if($row['id']==$_POST['parent']){ 
		echo "<option value='$row[id]' selected>$row[name]</option>";
		option_sub_menu($row['id'],$_POST['parent_id'],'');
	}
	else {
		echo "<option value='$row[id]'>$row[name]</option>";option_sub_menu($row['id'],$_POST['parent'],'');
	}
}				

function option_sub_menu($parent_id,$sub = NULL,$pre) {
	if($_POST['id']) $eid = "AND id!=$_POST[id]"; else $eid = '';
	$sql = DB::table(FDBPrefix."menu")->select('name, parent_id, id')->where("parent_id=$parent_id $eid")->get();  
	foreach($sql as $row){	
		if($sub==$row['id']) $s="selected"; else $s="";
		echo "<option value='$row[id]' $s>$pre|_ $row[name]</option>";
		option_sub_menu($row['id'],$sub,$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");	
	}	
}