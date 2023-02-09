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
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `Email` = :email ');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count > 0 ){
			return true; 
		}else{
			return false;
		}

	}
	public function checkReferalCode($referalcode){
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `Referal_Code` = :referalcode ');
		$stmt->bindParam(':referalcode', $referalcode, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function loggedIn(){
		return (isset($_SESSION['ID'])) ? true : false;
	}
	public function signup($email, $password,$firstname,$lastname,$referedby,$referalcode){
		date_default_timezone_set("Asia/Calcutta");
		$date = date('d/m/y');
		$password .= 'aj!1sa0#';
		$passhash = password_hash($password, PASSWORD_BCRYPT);
		$query = 'INSERT INTO `users`(`Email`, `Password`,`First_Name`,`Last_Name`,`Referal_Code`,`Referal_By`,`start_date`) VALUES (:email , :pass , :firstname ,:lastname ,:referalcode , :referdby,:start_dte)';
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':pass', $passhash, PDO::PARAM_STR);
		$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
		$stmt->bindValue(':referalcode', $referalcode, PDO::PARAM_STR);
		$stmt->bindValue(':referdby', $referedby, PDO::PARAM_STR);
		$stmt->bindValue(':start_dte', $date, PDO::PARAM_STR);
		$stmt->execute();

		$ID = $this->pdo->lastInsertId();
		$_SESSION['ID'] = $ID;

		//method to create data in wallet
		$qurey ='INSERT INTO `wallet`(`ID`, `total_earnings`, `account_balance`, `withdraw_amount`, `processing_amount`, `amount_spent`, `referal_earnings`) VALUES(:ID, :total_earnings, :account_balance, :withdraw_balence,:processing_amount,:amount_spent,:referal_earnings)';
		$stmt =$this->pdo->prepare($qurey);
		$value = 0;
		$stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
		$stmt->bindValue(':total_earnings', $value, PDO::PARAM_INT);
		$stmt->bindValue(':account_balance', $value, PDO::PARAM_INT);
		$stmt->bindValue(':withdraw_balence', $value, PDO::PARAM_INT);
		$stmt->bindValue(':processing_amount', $value, PDO::PARAM_INT);
		$stmt->bindValue(':amount_spent', $value, PDO::PARAM_INT);
		$stmt->bindValue(':referal_earnings', $value, PDO::PARAM_INT);
		$stmt->execute();

		//method to create withdrawdata
		$que = 'INSERT INTO `withdrawdata`(`ID`) VALUES(:ID)';
		$stmt = $this->pdo->prepare($que);
		$stmt = $this->pdo->prepare($que);
		$stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
		$stmt->execute();

		//method to create data in verification
		$qu ='INSERT INTO `verification`(`ID`) VALUES(:ID)';
		$stmt = $this->pdo->prepare($qu);
		$stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
		$stmt->execute();

		//method to create data in verification
		$qu ='INSERT INTO `instawork`(`ID`) VALUES(:ID)';
		$stmt = $this->pdo->prepare($qu);
		$stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
		$stmt->execute();


		//directory creation to store uploaded images.
		$path = 'userdata/'.$ID;
		mkdir($path);
		header('Location: user/index.php');
	}
	public function generatereferalcode(){
		$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
		return substr(str_shuffle($str_result), 0, 6);
	}
	public function login($email,$pass){
		$pass .= 'aj!1sa0#';
		$passhash = password_hash($pass , PASSWORD_BCRYPT);
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `email` = :email ');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		$user = $stmt->fetch(PDO::FETCH_OBJ);

		if($count > 0){
			if(password_verify($pass,$user->Password)){
				$_SESSION['ID'] = $user->ID;
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

	//get data by id 
	public function getreferaldata($referalcode){
		$query="SELECT * FROM `users` WHERE `Referal_By` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $referalcode, PDO::PARAM_STR);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{ 
			$earnings = $row['total_earnings'];
			$earnings =$earnings/100;
            $earnings = $earnings*5;
            if($earnings >= 50){
                $earnings = 50;
            }else{
                $earnings = $earnings;
            }
			echo'
				<tr>
                <td>'.$row['First_Name'].' '.$row['Last_Name'].'</td>
				<td>'.$row['Email'].'</td>
				<td>'.$row['start_date'].'</td>
				<td>'.$row['total_earnings'].'</td>
				<td>'.$earnings.'</td></tr>
			
			';

		}
		
	}
	public function getuserdata($ID){
        $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `ID` = :ID');
		$stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function verificationdatabyid($ID){
        $stmt = $this->pdo->prepare('SELECT * FROM `verification` WHERE `ID` = :ID');
		$stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function gettransactiondatabyid($id){
		$query = "SELECT * FROM `transactions` WHERE `ID` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $id, PDO::PARAM_STR);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{ 
			echo'
			<tr>
                <td>'.$row['date'].'</td>
                <td>'.$row['time'].'</td>
                <td>'.$row['amount'].'</td>
				<td>'.$row['status'].'</td>
				<td>'.$row['method'].'</td>
				<td>'.$row['transactionID'].'</td>
				<td>'.$row['remarks'].'</td>
            </tr>
			';

		}
	}

	public function getreferalcount($referalcode){
		$query="SELECT * FROM `users` WHERE `Referal_By` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $referalcode, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		echo $count;

	}
	public function uploadImage($file,$ID){
		$filename   = $file['name'];
		$fileTmp    = $file['tmp_name'];
		$fileSize   = $file['size'];
		$errors     = $file['error'];
		$ext = explode('.', $filename);
		$ext = strtolower(end($ext));
 
		$allowed_extensions  = array('jpg','png','jpeg');
	
		if(in_array($ext, $allowed_extensions)){
			
			if($errors ===0){
				
				if($fileSize <= 2097152){
					 $root = 'userdata/'.$ID.'/ ' . $filename;
					   move_uploaded_file($fileTmp,$_SERVER['DOCUMENT_ROOT'].'/'.$root);
  
				}else{
						$GLOBALS['imgError'] = "File Size is too large";
					}
			}
		  }else{
					$GLOBALS['imgError'] = "Only alloewd JPG, PNG JPEG extensions";
				 }
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
}
