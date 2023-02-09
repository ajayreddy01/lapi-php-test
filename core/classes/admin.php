<?php 
class admin{
    protected $pdo;
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}
	public function adminloggedIn(){
		return (isset($_SESSION['Email'])) ? true : false;
	}    
}
?> 