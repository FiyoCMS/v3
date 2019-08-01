<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(@$_SESSION['USER_LEVEL'] > 5 or !isset($_GET['iSortCol_0'])) die ('Access Denied!');
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
header('Content-Type: application/json');

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$sTable = FDBPrefix."user";
	$sTable2 = FDBPrefix."user_group";

	$aColumns =[
		"$sTable.id", 
		'name', 
		"user", 
		'email', 
		"status", 
		"$sTable.level", 
		"$sTable.id", 
		"group_name" ,
		];
		
		$aWhereColumns =[
		"$sTable.id", 
		'name', 
		"status", 
		"user", 
		'email', 
		"$sTable.level", 
		"group_name" ,
		];
	
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	
	/* DB table to use */
	$sJoin = "LEFT JOIN $sTable2 ON $sTable.level = $sTable2.level";
	
	/* 
	 * Paging
	 */
	$sLimit = "LIMIT 10";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "ORDER BY id desc";
	
	if (isset($_GET['iSortCol_0']) AND !empty($_GET['iSortCol_0']))
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$data = str_replace(".","`.`",$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]);				
				$c =strpos($aColumns[ intval( $_GET['iSortCol_'.$i] ) ],"as");
				if($c) { $c += 3;
					$data = substr($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], $c);
				}
				$sOrder .= "`". $data ."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	if(!empty($_GET['level'])) $level = "  $sTable.level = '$_GET[level]'  AND "; 
	else $level = '';
	
	$sWhere = " WHERE  $level $sTable.level >= $_SESSION[USER_LEVEL] ";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere .= " AND(";
		for ( $i=0 ; $i<count($aWhereColumns) ; $i++ )
		{

			$data = str_replace(".","`.`",$aWhereColumns[$i]);
			$sWhere .= "`".$data."` LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "AND " )
			{
				$sWhere .= " ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
		}
	}	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" as ", "` as `", str_replace(".","`.`", str_replace(" , ", " ", implode("`, `", $aColumns))))."`
		FROM  $sTable $sJoin
		$sWhere 
		$sOrder
		$sLimit
		";

		
	$rResult = Database::query($sQuery);
	//echo DB::$query;
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = Database::query($sQuery)->fetchColumn();
	$iFilteredTotal = $rResultFilterTotal;
	//echo $iFilteredTotal;
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";	
	$rResultTotal = Database::query($sQuery)->fetchColumn();
	$iTotal = $rResultTotal;	
	/*
	 * Output
	 */

	$output = array(
		"sEcho" => intval(@$_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	foreach ( $rResult as $aRow )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{	
			/* logika status aktif atau tidak */
				/* logika status aktif atau tidak */
			if($aRow['status']==1)
			{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
			else
			{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
												
			$title = $aRow['name'];
			if($_SESSION['USER_LEVEL'] == 1 OR $_SESSION['USER_ID'] == $aRow['id'] AND $_SESSION['USER_LEVEL'] <=3) {
				$checkbox ="<label><input type='checkbox' data-name='rad-$aRow[id]' name='check[]' value='$aRow[id]' rel='ck' ><span class='input-check'></span></label>";
				
				$name ="<a class='tips' title='".Edit."' href='?app=user&act=edit&id=$aRow[id]' target='_self' data-placement='right'>$title</a>";	
					
				$status ="<span class='invisible'>$enable</span>
				<div class='switch s-icon activator editor'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-check-circle'></i></span></label>
					<input type='hidden' value='$aRow[id]' class='number invisible'>
					<input type='hidden' value='$aRow[status]'  class='type invisible'>
				</div>";

			}
			else {	
				$name =  $title;
				$checkbox = "<span class='icon lock'></lock>";
					
				$status ="<span class='invisible'>$enable</span>
				<div class='switch s-icon activator'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-check-circle'></i></span></label>
					<input type='hidden' value='$aRow[id]' class='number invisible'>
					<input type='hidden' value='$aRow[status]'  class='type invisible'>
				</div>";
				
									
			}					
			if ( $i == 0 )
			{			
				if(!isset($_GET['param']))
				$row[] = $checkbox; 
			}				
			else if ( $i == 1 )
			{	
				if(!isset($_GET['param']))
					$row[] = $name;
				else
					$row[] ="<a class='tips select' rel='$aRow[id]' title='".Choose."' href='#' target='_self' redata-placement='right'>$title</a>";					
			}			
			else if ( $i == 2 )
			{			
				$row[] = "<div class='left'>".$aRow["user"]."</div>";
			}	
			else if ( $i == 3 )
			{		
				$level = $aRow['email'];
				$row[] = "<div class='left'>$level</div>";
			}
			else if ( $i == 4 )
			{			
				$row[] = "<div class='center'>$status</div>";
			}
			else if ( $i == 5 )
			{			
				
				$row[] = "<div class='left'>".$aRow["group_name"]."</div>";
			}
			else if ( $i == 6 )
			{		
				$row[] = "<div class='center'>$aRow[id]</div>";
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>