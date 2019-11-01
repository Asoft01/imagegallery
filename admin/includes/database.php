<?php
require_once('new_config.php');
class Database{
	public $connection;
	function __construct(){
		$this->open_db_connection();
	}

	public function open_db_connection(){
		//$this->connection= mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$this->connection= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($this->connection->connect_errno) {
			die("Database connection Failed".$this->connection->connect_error);
		}
		// if (mysqli_connect_errno()) {
		// 	die("Database connection Failed Badly".mysqli_error());
		// }
	}

	public function query($sql){
		$result= $this->connection->query($sql);
		//$result= mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}

	public function confirm_query($result){
		if (!$result) {
			//die("Query Failed".mysqli_errno);
			die("Query Failed".$this->connection->error);
		}
	}


	public function escape_string($string){
		$escaped_string= $this->connection->real_escape_string($string);
		//$escaped_string= $this->connection->real_escape_string($string);
		//$escaped_string= mysqli_real_escape_string($this->connection, $string);
		return $escaped_string;
	}

	public function the_insert_id(){
		return $this->connection->insert_id;
		//return mysqli_insert_id($this->connection);
	}
}

$database= new Database();
//$database->open_db_connection();
// We need this if there is a no function __construct on line 6


?>