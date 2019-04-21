<?php  

class db{
	
	//connect to the database
	public function connect(){
		$mysql_connect_str = "mysql:host=localhost;dbname=slimapp";
		
		$dbConnection = new PDO($mysql_connect_str,'root','');

		$dbConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		return $dbConnection;

	}



}



?>