<?php 
	session_start();
	include 'db.php';
	include 'users.php';
	include 'wallet.php';
	include 'admin.php';
	include 'includes.php';
	
  	global $pdo;
	  $getFromU = new User($pdo);
	  $getFromW = new Wallet($pdo);
	  $getFromA = new admin($pdo);
	  $getFromIn = new includes();
  	define('BASE_URL', 'http://localhost/');
?>                                                   
 