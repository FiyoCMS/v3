<?php 
/**
* version   2.5
* package   Fiyo CMS
* copyright Copyright (C) 2012 Fiyo CMS.
* license   GNU/GPL, see LICENSE.txt
**/

/*
* Define database variables
*/ 
define('FDBUser', $DBUser);
define('FDBPass', $DBPass);
define('FDBHost', $DBHost);
define('FDBName', $DBName);
define('FDBPrefix', $DBPrefix);

class Database extends Controller {   

    private static $db_host = FDBHost;	// Database Host
    private static $db_user = FDBUser;	// Username
    private static $db_pass = FDBPass;	// Password
    private static $db_name = FDBName; 	
	
	private static $table;	
    private static $rows = '*';
    private static $join = '';
    private static $where;
    private static $orderBy;
    private static $groupBy;
    private static $limit;
    private static $_instance = null;
    private static $self_query = false;

    private static $newconn = null;
	
    public static $query;    // variabel Last Query
    public static $error;    // variabel Last Error
    public static $last_id;    // variabel Last Query
    public static $db  = false;     
    public $result = null;   // Cek untuk melihat apakah sambungan aktif

    public function __construct () { 
		$this->middleware;	
	}
	
	public static function connect($dbname = null, $host = null, $user = null, $pass = null)
	{        
        static $conn = false;
        
        if(isset($dbname)) {
            self::$db_host = $host;	// Database Host
            self::$db_user = $user;	// Username
            self::$db_pass = $pass;	// Password
            self::$db_name = $dbname; 	
        }   else {
            self::$db_host = FDBHost;	// Database Host
            self::$db_user = FDBUser;	// Username
            self::$db_pass = FDBPass;	// Password
            self::$db_name = FDBName; 
        }
        if(!$conn or !empty($host)){ 
            try{
                $options = array(
                PDO::ATTR_PERSISTENT    => false,
                PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION);
                self::$db = $conn = new PDO("mysql:host=".
				self::$db_host.";dbname=".
				self::$db_name.";charset=utf8",
				self::$db_user, 
                self::$db_pass, $options);
            }
            catch(PDOException $e){				
                alert('error',self::$db_host.'Unable to connect database!',true,true);
                }
        } else self::$db = $conn;	
    }

    
	public static function reConnect()
	{
          return self::connect(FDBName, FDBHost, FDBUser, FDBPass);     
    }

    public static function table($value)
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        self::$self_query = false;
        self::$where = null;
        self::$orderBy = null;
        self::$limit = null;
        self::$join = null;
        self::$rows = '*';
		
        self::$table = $value;
        return self::$_instance;
    }

    public function select($rows) {
        self::$rows = $rows;
        return $this;
    }
	
    public function where($where = '*') {
        self::$where = $where;
        return $this;
    }
	
    public function wheres($where = '*') {
        self::$where = $where;
        return $this;
    }
	
    public function rows(array $rows) {
        self::$rows = $rows;
        return $this;
    }

    public function orderBy($orderBy = null) {
        self::$orderBy = $orderBy;
        return $this;
    }

    public function groupBy($groupBy = null) {
        self::$groupBy = $groupBy;
        return $this;
    }

    public function limit($limit = null) {
        self::$limit = $limit;
        return $this;
    }


    public function leftJoin($joinTable = null, $join = null) {
        self::$join .= " LEFT JOIN $joinTable ON $join";
        return $this;	
    }
		
	public static function query($query, $fetch = false, $error = true){
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        static $cons = false;		        
		try{
            $result = self::connect();   
            $result = self::$db->prepare($query);                
            self::$query = $query;           
            self::$self_query = true;
            $result ->execute();
			if($fetch)
				return $result->fetchAll(PDO::FETCH_ASSOC);
			else {                
                return $result;
            }
		}
		catch(PDOException $e){
		    self::$error = $e;
			if(!$cons) {
                if(_SHOW_ERROR_)
                    echo($e);		
                $cons = true;
				return false;	
			}
		}
    }
    
    
    public static function row()
    {
        if(!self::$self_query) {
            if(_SHOW_ERROR_)
            alert("error", "Can't call <b>DB::table</b> with <b>row()</b> function.", true);
            return false;
        }

        try{            
            $query = self::$query;        
            self::connect();   
            $result = self::$db->prepare($query);   
            $result->execute();
			return $result->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
		    self::$error = $e;
            if(_SHOW_ERROR_)
                echo($e);		
		}
        
    }
	
    /*
    * Cek apakah tabel setting ada
	* Sebelum melakukan query lanjutan
    */
    public static function tableExists($table)
    {
        $sql = 'SHOW TABLES FROM '.self::$db_name.' LIKE "'.$table.'"';
        $result = self::query($sql, true);
        self::$query = $sql;
        
        if($result)
        {
            if(count($result))
            {
                return true;
            }
        }
        return false;
        
    }

    public function get() {	
		$sql = "SELECT ". self::$rows . " FROM `". self::$table . "`";
		
        if(self::$join != null)
            $sql .= self::$join;	
		if(self::$where != null)
            $sql .= ' WHERE '.self::$where;
        if(self::$groupBy != null)
            $sql .= ' GROUP BY '.self::$groupBy;	
        if(self::$orderBy != null)
            $sql .= ' ORDER BY '.self::$orderBy;	
        if(self::$limit != null)
            $sql .= ' LIMIT '.self::$limit;	
            
		self::$query = $sql;
		static $cons = false;
		try{
			$result = self::connect();           
            $result = self::$db->prepare($sql);            
            $result -> execute();
            
            self::$join     = null;
            self::$where    = null;
            self::$groupBy  = null;	
            self::$orderBy  = null;	
            self::$limit    = null;
            
			return $result->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
		    self::$error = $e;
            if(!$cons) { 
                if(_SHOW_ERROR_) {
                    $msg = $e->getMessage();
                    $pos = strpos($e->getMessage(), ":");
                    $err = substr($msg, $pos + 1);                    
                    alert('error',trim($err),true,true);
                }
			$cons = true;		
			return false;
			}
		}		
    }
	
	public function insert($values, $rows = null)
    {
        $insert = 'INSERT INTO '. self::$table ;
        $kuot = $arkey = false;
		
        if(isset($values[0])) {
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = "'".$values[$i]."'";
            }
        } else {
            $rows = array_keys($values);
            foreach ($rows as $k => $r)
                $rows[$k] = '`'.$r.'`';
            $rows = implode(',',$rows);
            $insert .= ' ('.$rows. ')';
			$arkey = true;
        }
		

        if(is_array($values)) {
            foreach ($values as $k => $r) {
                if(!empty($r)) {
                    if($arkey)
                        $kuot = true;
                    else if(strpos('"',"$r") === 0 or strpos("'","$r") === 0 )
                        $kuot = true;
                    
                }
                if(empty($r)) {
                    $kuot = true;     
                }			
                
                if($kuot) 
                $values[$k] = "'".$r."'";
            }
             $values = implode(',',$values);
        }
        
        $insert .= ' VALUES ('.$values.')';
		
		self::$query = $insert;	
		static $cons = false;
		try{
			$result = self::connect();        
			$result = self::$db->prepare($insert);
			$query = $result ->execute();
            self::$last_id = self::$db->lastInsertId();
        }
		catch(PDOException $e){
		    self::$error = $e;
			if(!$cons) {	
				Controller::setError();		
				Controller::pushError($e);
			    $cons = true;
				return false;
			}
		}       
		
		if(isset($query)) {
            return true;
        }
    }
	
	
    public function update(array $rows = [])
    {        
        $update = 'UPDATE '.self::$table.' SET ';
        $keys = array_keys($rows);
		
        for($i = 0; $i < count($rows); $i++){
            if(is_string($rows[$keys[$i]]) AND $rows[$keys[$i]] !== '+hits')
            {
                $update .= '`'.$keys[$i].'`="'.$rows[$keys[$i]].'"';
            }
            else
            {
				if($rows[$keys[$i]] == '+hits') $rows[$keys[$i]] = $keys[$i] . '+'. 1;
                 $update .= '`'.$keys[$i].'`='.$rows[$keys[$i]];
            }

            // Parse to add commas
            if($i != count($rows)-1)
            {
                $update .= ',';
            }
        }
		
		if(self::$where != null) {
            $update .= ' WHERE '.self::$where;
		}
		
		self::$query = $update;	
		static $cons = false;
		try{
			$result = self::connect();      
			$result = self::$db->prepare($update);
			$query = $result ->execute();
        }
		catch(PDOException $e){
		    self::$error = $e;
			if(!$cons) {	
				Core::setError();		
                Core::pushError($e);	
                
			    $cons = true;
				return false;
			}
		}       
		
		if(isset($query)) {
            return true;
        }
		
		
	}
	
	public static function delete($where = null)
    {
        $table = self::$table;
		
        if($where == null)
            {
            $delete = 'DELETE FROM '.$table;
        }
        else
        {
            $delete = 'DELETE FROM '.$table.' WHERE '.$where;
        }
			
		self::$query =  $delete ;	
		static $cons = false;
		try{
			$result = self::connect();        
			$result = self::$db->prepare($delete);
			$query = $result ->execute();
        }
		catch(PDOException $e){
		    self::$error = $e;
			if(!$cons) {		
				Core::setError();		
				Core::pushError($e);	
			    $cons = true;
				return false;
			}
		}
        
		if(isset($query)) {
            return true;
        }
    }

}

class_alias('Database', 'DB');
class_alias('Database', 'FQuery');

