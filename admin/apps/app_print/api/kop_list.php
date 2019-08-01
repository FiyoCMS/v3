<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
if(USER_LEVEL > 5) die ('Access Denied!');
header('Content-Type: application/json');

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$sTable	 = FDBPrefix."print_kop";

	$aColumns =[
		"kop_id", 
		'name', 
		'text', 
		];
		
	$aWhereColumns =[
		"kop_id", 
		'name', 
		'text', 
	];
	
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "name";
	
	/* DB table to use */
	$sJoin = "";
	
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
	$sOrder = "ORDER BY $sIndexColumn desc";
	
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
	
	$sWhere = " WHERE true";
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
								
			$title = $aRow['name'];
			if($_SESSION['USER_LEVEL'] == 1 OR $_SESSION['USER_ID'] == $aRow['author_id'] AND $aRow['author_id'] != 0 OR ($_SESSION['USER_LEVEL'] <= $editor_level OR (empty($editor_level) AND $_SESSION['USER_LEVEL'] <=3))) {
				$checkbox ="<label><input type='checkbox' data-name='rad-$aRow[kop_id]' name='check_kop[]' value='$aRow[kop_id]' rel='ck' ><span class='input-check'></span></label>";
				
				$name ="<a class='tips' title='".Edit."' href='?app=$app[root]&view=kop&act=edit&id=$aRow[kop_id]' target='_self' data-placement='right'>$title</a>";	
					
							
			}
			else {	
				$name =  $title;
				$checkbox = "<span class='icon lock'></lock>";
			
									
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
				if(!isset($_GET['param']))
				$row[] = "<div class='switch-group'> </div>";
			}	
			else if ( $i == 3 )
			{			
				$row[] = "<div class='center'>".$aRow["category"]."</div>";
			}
			else if ( $i == 4 )
			{							
				$aut = DB::table(FDBPrefix."user")->select('name')->where("id = '$aRow[author_id]'")->get();
				if(isset($aut[0])) 
				$author = $aut;
				else
				$author = null;
				if(!empty($aRow['author']))
					$author = $aRow['author'];					
				else if(empty($author))
					$author="<span title='Original by Anonymous' class='tips'>Anonymous</span>";
				else
					$author="<span title='Original by $aut' class='tips'>$author</span>";
				$row[] = "<div class='center'>$author</div>";
			}
			else if ( $i == 5 )
			{		
				$row[] = "<div class='center'> </div>";
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>