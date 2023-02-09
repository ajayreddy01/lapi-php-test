<?php 
	session_start();
	include 'db.php';
	include 'user.php';
	include 'dicegame.php';
	include 'colourgame.php';
	include 'includes.php';

  	global $pdo;
	$getFromU = new User($pdo);
	$getFromG = new DiceGame($pdo);
	$getFromC = new ColourGame($pdo);
	$getFromIncludes = new includes();

?>  

