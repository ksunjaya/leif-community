<?php

class MySQLDB{
	protected static $servername = 'localhost';
	protected static $username = 'root';
	protected static $password = '';
	protected static $dbname = 'leifcommunity';
	protected $db_connection;

	public function __construct()
	{

	}
	public function openConnection()
	{	
		//create connection
		$this->db_connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

		//check connection
		if ($this->db_connection->connect_error)
		{
			die ('Could not connect to'.$this->servername.' server');
		}
	}
	public function executeSelectQuery ($sql)
	{
		$this -> openConnection();
		$query_result = $this -> db_connection -> query($sql);
		$result = [];
		if ($query_result->num_rows > 0)
		{
			while ($row = $query_result -> fetch_assoc())
			{
				$result[] = $row;
			}
		}
		$this -> closeConnection();
		return $result;
	}
	public function executeNonSelectQuery ($sql)
	{
		$this->openConnection();
		$query_result = $this->db_connection->query($sql); // TRUE / FALSE
		$this->closeConnection();
		return $query_result;
	}
	public function closeConnection()
	{
		$this->db_connection->close();
	}
	public function escapeString ($str) {
		$this->openConnection();
		return $this->db_connection->escape_string($str);
	}

	public static function createBuilder(){
		$connection = new PDO('mysql:host='.MySQLDB::$servername.';dbname='.MySQLDB::$dbname.';charset=utf8', MySQLDB::$username, MySQLDB::$password);

		// create a new mysql query builder
		$h = new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) use($connection)
		{
			$statement = $connection->prepare($queryString);
			$statement->execute($queryParameters);

			// when the query is fetchable return all results and let hydrahon do the rest
			// (there's no results to be fetched for an update-query for example)
			if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface)
			{
				return $statement->fetchAll(\PDO::FETCH_ASSOC);
			}
			// when the query is a instance of a insert return the last inserted id  
			elseif($query instanceof \ClanCats\Hydrahon\Query\Sql\Insert)
			{
				return $connection->lastInsertId();
			}
			// when the query is not a instance of insert or fetchable then
			// return the number os rows affected
			else 
			{
				return $statement->rowCount();
			}	
		});

		return $h;
	}
}