<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 5) die ('Access Denied!');
header('Content-Type: application/json');
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'id', 'link', 'permalink', 'locker', 'pid');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	
	$sIndexOrder = 'locker';
	
	/* DB table to use */
	$sTable = FDBPrefix."permalink";
	
	/* Database connection information */
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	/* 
	 * Paging
	 */
	$sLimit = "LIMIT 10";
	if (  Input::get('iDisplayStart')  && Input::get('iDisplayLength') != '-1' )
	{
		$sLimit = "LIMIT ".intval( Input::get('iDisplayStart') ).", ".
			intval( Input::get('iDisplayLength') );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "ORDER BY $sIndexOrder DESC";
	if (Input::get('iSortCol_0') AND Input::get('iSortCol_0'))
		{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( Input::get('iSortingCols') ) ; $i++ )
		{
			if ( Input::get( 'bSortable_'.intval(Input::get('iSortCol_'.$i)) ) == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( Input::get('iSortCol_'.$i) ) ]."` ".
					(Input::get('sSortDir_'.$i)==='asc' ? 'asc' : 'desc') .", ";
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
	$sWhere = "";
	if ( Input::get('sSearch') && Input::get('sSearch') != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".addslashes( Input::get('sSearch') )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( Input::get('bSearchable_'.$i) && Input::get('bSearchable_'.$i) == "true" && Input::get('sSearch_'.$i) != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".addslashes(Input::get('sSearch_'.$i))."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
	$rResult = DB::query( $sQuery);
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = DB::query( $sQuery)->fetchColumn();
	$iFilteredTotal = $rResultFilterTotal;
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	
	$rResultTotal = DB::query( $sQuery)->fetchColumn();
	$iTotal = $rResultTotal;
	
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval(Input::get('sEcho')),
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
			if($aRow['locker']==1)
			{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
			else
			{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
					
			
				$status ="<p class='switch locker'><label class='cb-enable $stat1'><span>&nbsp;Lock&nbsp;</span></label><label class='cb-disable $stat2'><span>Unlock</span></label> <input type='hidden' value='$aRow[id]' class='number invisible'><input type='hidden' value='$aRow[locker]' class='type invisible'></p>";
						
							
							
			if ( $i == 0 )
			{			
				$row[] = "<label><input type='checkbox' data-name='rad-$aRow[id]' name='check[]' value='$aRow[id]' rel='ck' ><span class='input-check'></span></label>"; 
			}				
			else if ( $i == 1 )
			{			
				$name = "$aRow[permalink]";
				$name = "<a href='?app=permalink&act=edit&id=$aRow[id]' class='tips' title='Edit' data-placement='right'>$name</a>";	
				$row[] = $name;
			}			
			else if ( $i == 2 )
			{			
				$link = htmlentities(htmlToText($aRow['link']));
				$link = substr($link,0,50);
				
				$link ="<a class='tips' title='".Edit."' href='?app=permalink&act=edit&id=$aRow[id]'  data-placement='right'>$link</a>";
				$row[] = "$link";
			}	
			else if ( $i == 3 )
			{			
				$row[] = "<div class='center'>$status</div>";
			}
			else if ( $i == 4 )
			{							
		
				$row[] = "<div class='center'>$aRow[pid]</div>";
			}
			
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>