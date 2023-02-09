<?php 
 /* 
	Developed By 
		->Ajay Reddy Chinthala(IG::@ajay_reddy_01)
		->Sohail Ashraf (IG::@sohail__ashraf)

 */
	$dsn = 'mysql:host=localhost; dbname=mydb';
	$user = 'root';
	$password = '';
 

	try{
		$pdo = new PDO($dsn, $user, $password);
	}catch(PDOException $e){
		echo 'connection error! ' . $e;
	}	
?>