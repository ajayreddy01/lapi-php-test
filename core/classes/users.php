<?php
/* 
	Developed By 
		->Ajay Reddy Chinthala(IG::@ajay_reddy_01)
		->Sohail Ashraf (IG::@sohail__ashraf)
*/

class User{
	protected $pdo;
	public function __construct($pdo){
		$this->pdo = $pdo;
	}
	public function checkinput($data){
		$data = htmlspecialchars($data);
		$data = trim($data);
		$data = stripcslashes($data);
		return $data;
	}
	public function checkeamil($email){
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `eamil` = :email ');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count > 0 ){
			return true; 
		}else{
			return false;
		}
	}
	public function checkph($phno){
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `phonenumber` = :email ');
		$stmt->bindParam(':email', $phno, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count > 0 ){
			return true; 
		}else{
			return false;
		}
	}
	public function checkreferalcode($code){
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `referalcode` = :email ');
		$stmt->bindParam(':email', $code, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count > 0 ){
			return true; 
		}else{
			return false;
		}
	}
	public function generatereferalcode(){
		$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
		return substr(str_shuffle($str_result), 0, 6);
	}
	public function loggedIn(){
		return (isset($_SESSION['id'])) ? true : false;
	}
	public function signup($email, $password,$name,$phonenumber,$insta,$tele,$facebook,$referedby,$referalcode){
		date_default_timezone_set("Asia/Calcutta");
		$date = date('d/m/y');
		$password .= 'aj!1sa0#';
		$passhash = password_hash($password, PASSWORD_BCRYPT);
		$query = 'INSERT INTO `users`(`eamil`,`password`,`name`,`referalcode`,`referedby`,`phonenumber`,`instagram`,`telegram`,`facebook`,`start_date`,`status`) VALUES (:email , :pass , :fname ,:referalcode , :referdby,:phno,:instagram,:telegram,:facebook,:start_dte,:stat)';
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		//:email,:pass,:fname,:referalcode,:referdby,:phno,:instagram,:telegram,:facebook,:start_dte,:stat
		$stmt->bindValue(':pass',$passhash,PDO::PARAM_STR);
		$stmt->bindValue(':fname',$name,PDO::PARAM_STR);
		$stmt->bindValue(':referalcode',$referalcode,PDO::PARAM_STR);
		$stmt->bindValue(':referdby',$referedby,PDO::PARAM_STR);
		$stmt->bindValue('phno',$phonenumber,PDO::PARAM_STR);
		$stmt->bindValue(':instagram',$insta,PDO::PARAM_STR);
		$stmt->bindValue(':telegram',$tele,PDO::PARAM_STR);
		$stmt->bindValue(':facebook',$facebook,PDO::PARAM_STR);
		$stmt->bindValue(':stat',$date,PDO::PARAM_STR);
		$stmt->execute();

		$id = $this->pdo->lastInsertId();
		$_SESSION['id'] = $id;

		$qurey ='INSERT INTO `wallet`(`id`, `capthaearnings`, `captha`, `winning`, `withdrawn`, `accountbal`, `spentonbet`) VALUES(:id, :capthaearnings, :captha, :winning,:withdrawn,:accountbal,:spentonbet)';
		$stmt =$this->pdo->prepare($qurey);
		$value = 0;
		//:id, :capthaearnings, :captha, :winning,:withdrawn,:accountbal,:spentonbet
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':capthaearnings', $value, PDO::PARAM_INT);
		$stmt->bindValue(':captha', $value, PDO::PARAM_INT);
		$stmt->bindValue(':winning', $value, PDO::PARAM_INT);
		$stmt->bindValue(':withdrawn', $value, PDO::PARAM_INT);
		$stmt->bindValue(':accountbal', $value, PDO::PARAM_INT);
		$stmt->bindValue(':spentonbet', $value, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: /user/index.php');

	}
	public function login($email,$pass){
		$pass .= 'aj!1sa0#';
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `email` = :email ');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		$user = $stmt->fetch(PDO::FETCH_OBJ);

		if($count > 0){
			if(password_verify($pass,$user->Password)){
				$_SESSION['id'] = $user->id;
				$_SESSION['loggedin'] = true;
				header('Location: /user/index.php');

			}
		}else{
			return false;
		}
	}
	public function logout(){
		$_SESSION = array();
		session_destroy();
		header('Location: index.php');
	}
	public function getreferaldata($referalcode){
		$query="SELECT * FROM `users` WHERE `referedby` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $referalcode, PDO::PARAM_STR);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{ 
			
			echo'
				<tr>
                <td>'.$row['name'].'</td>
				<td>'.$row['eamil'].'</td>
				<td>'.$row['phonenumber'].'</td>
				<td>'.$row['start_date'].'</td>
				<td>'.$row['status'].'</td>
			';
		}
		
	}
	//get data by id 
	public function getuserdata($ID){
        $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `id` = :ID');
		$stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function getwalletdata($ID){
        $stmt = $this->pdo->prepare('SELECT * FROM `wallet` WHERE `id` = :ID');
		$stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function update($table, $ID, $fields){
		$columns = '';
		$i       = 1;

		foreach ($fields as $name => $value) {
			$columns .= "`{$name}` = :{$name} ";
			if($i < count($fields)){
				$columns .= ', ';
			}
			$i++;
		}
		$sql = "UPDATE {$table} SET {$columns} WHERE `ID` = {$ID}";
		if($stmt = $this->pdo->prepare($sql)){
			foreach ($fields as $key => $value) {
				$stmt->bindValue(':'.$key, $value);
			}
			$stmt->execute();
		}
	}
	public function getwithdrawdata($id){
		$stmt = $this->pdo->prepare('SELECT * FROM `withdrawdata` WHERE `id` = :ID');
		$stmt->bindParam(':ID', $id, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}
}