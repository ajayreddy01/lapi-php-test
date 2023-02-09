<?php
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
    public function sup($email,$password){
        $password .= 'aj!1sa0#';
		$passhash = password_hash($password, PASSWORD_BCRYPT);
		$query = 'INSERT INTO `users`(`email`, `password`) VALUES (:email , :pass)';
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':pass', $passhash, PDO::PARAM_STR);
		$stmt->execute();
		$id = $this->pdo->lastInsertId();
		$_SESSION['id'] = $id;
		$query = 'INSERT INTO `wallet`(`id`) VALUES (:id)';
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		header('Location: index.php');
    }
	public function login($email,$pass){
		$pass .= 'aj!1sa0#';
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `email` = :email ');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		if($count > 0){
			if(password_verify($pass,$user->password)){
				$_SESSION['id'] = $user->id;
				$_SESSION['loggedin'] = true;
				header('Location: index.php');
			}
		}else{
			return false;
		}
	}
	public function logout(){
		session_destroy();
		header('Location: login.php');
	}
	public function logedin(){
		return isset(($_SESSION['loggedin'])) ?  true : false;
	}

	public function update($table, $id, $fields){
		$columns = '';
		$i       = 1;

		foreach ($fields as $name => $value) {
			$columns .= "`{$name}` = :{$name} ";
			if($i < count($fields)){
				$columns .= ', ';
			}
			$i++;
		}
		$sql = "UPDATE {$table} SET {$columns} WHERE `id` = {$id}";
		if($stmt = $this->pdo->prepare($sql)){
			foreach ($fields as $key => $value) {
				$stmt->bindValue(':'.$key, $value);
			}
			$stmt->execute();
		}
	}
	public function getwalletdata($ID){
        $stmt = $this->pdo->prepare('SELECT * FROM `wallet` WHERE `id` = :ID');
		$stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function gamehistory($id){
		$sql = "SELECT * FROM `history` WHERE `userid` = {$id}";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$count = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $count = $count+1;
           echo  '<tr>
           <td>'.$row['periodid'].'</td>
		   <td>'.$row['betamount'].'</td>
           <td>'.$row['beton'].'</td>
		   <td>'.$row['result'].'</td>
           </tr>';
        }

	} 
}
?>