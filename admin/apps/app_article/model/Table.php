<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

class Table {	
	public static $message = null;
	public static $tableName = false;
	
	protected static $fillable =[
		"$sTable.id", 
		'title', 
		"$sTable.status", 
		"$sTable1.name as category", 
		'author_id', 
		"$sTable.level", 
		'date', 
		'hits', 
		'featured', 
		'parameter',
		"$sTable2.name as author",
		"$sTable3.group_name" ,
	];
		
	protected static $whereColl = [
		"$sTable.id", 
		'title', 
		"$sTable.status", 
		"$sTable1.name", 
		'author_id', 
		"$sTable.level", 
		'date', 
		'hits', 
		'featured', 
		'parameter',
		"$sTable2.name",
		"$sTable3.group_name" ,
	];
}
