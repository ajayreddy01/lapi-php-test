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
	public function login($email,$pass){
		$pass .= 'aj!1sa0#';
		$passhash = password_hash($pass , PASSWORD_BCRYPT);
		#$query = 'SELECT * FROM `users` WHERE `email` = :email ';
		$stmt = $this->pdo->prepare('SELECT * FROM `admin` WHERE `Email` = :email ');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		$admin = $stmt->fetch(PDO::FETCH_OBJ);

		if($count > 0){
			if(password_verify($pass,$passhash)){
				$_SESSION['Email'] = $admin->Email;
				$_SESSION['loggedin'] = true;
				header('Location: /user/index.php');

			}
		}else{
			return false;
		}

	}
	public function signup($email, $pass){

	}
	public function getuserdataforadmin(){
		$query="SELECT * FROM `users`";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$count = 0;
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$count = $count+$row['total_earnings'];
			echo'
				
				<tr>
					<td>'.$row['ID'].'</td>
					<td>'.$row['First_Name'].' '.$row['Last_Name'].'</td>
					<td>'.$row['Email'].'</td>
					<td>'.$row['start_date'].'</td>
					<td>'.$row['total_earnings'].'</td>
					<td>'.$row['Referal_Code'].'</td>
					<td>'.$row['Referal_By'].'</td>
				</tr>
			
			';

		}
		echo '
			<tfoot>
				<tr>
					<th>Total</th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th>'.$count.'</th>
					<th> </th>
					<th> </th>
				</tr>
			</tfoot>
		';
		
    }
    public function getwalletdataforadmin(){
		$query="SELECT * FROM `wallet`";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$te = 0;
		$ab = 0;
		$pa = 0;
		$wa = 0;
		$as = 0;
		$re = 0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{	
			$te = $te + $row['total_earnings'];
			$ab = $ab + $row['account_balance'];
			$pa = $pa + $row['processing_amount'];
			$wa = $wa + $row['withdraw_amount'];
			$as = $as + $row['amount_spent'];
			$re = $re + $row['referal_earnings'];
			
			echo'
				
				<tboby>
					<tr>
						<td>'.$row['ID'].'</td>
						<td>'.$row['total_earnings'].'</td>
						<td>'.$row['account_balance'].'</td>
						<td>'.$row['withdraw_amount'].'</td>
						<td>'.$row['processing_amount'].'</td>
						<td>'.$row['amount_spent'].'</td>
						<td>'.$row['referal_earnings'].'</td>
					</tr>
				</tbody>
				
			
			';
			

		}
		echo '
			<tfoot>
				<tr>
					<th>Total</th>
					<th>'.$te.'</th>
					<th>'.$ab.'</th>
					<th>'.$wa.'</th>
					<th>'.$pa.'</th>
					<th>'.$as.'</th>
					<th>'.$re.'</th>
				</tr>
			</tfoot>
		';
		
    }
    public function gettransactiondataforadmin(){
		$query="SELECT * FROM `transactions`";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$count = 0;
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$count = $count +$row['amount'];
            echo'<tr>
                <td>'.$row['ID'].'</td>
                <td>'.$row['date'].' '.'</td>
				<td>'.$row['time'].'</td>
				<td>'.$row['amount'].'</td>
                <td>'.$row['status'].'</td>
                <td>'.$row['method'].'</td>
				<td>'.$row['transactionID'].'</td>
				<td>'.$row['remarks'].'</td>
				</tr>
			
			';

		}
		echo '
		<tfoot>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>'.$count.'</th>
                <th>Status</th>
                <th>Method</th>
                <th>Transaction ID</th>
                <th>Remarks</th>
                </tr>
            </tfoot>';
		
    }
    public function getverificationdataforadmin(){
		$query="SELECT * FROM `verification`";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
            echo'<tr>
                <td>'.$row['ID'].'</td>
                <td>'.$row['type'].'</td>
				<td>'.$row['name'].'</td>
				<td>'.$row['number'].'</td>
                <td>'.$row['dob'].'</td>
                <td>'.$row['adress'].'</td>
				<td>'.$row['status'].'</td></tr>
			
			';

		}
		
    }
    public function getwithdrawndataforadmin(){
		$query="SELECT * FROM `withdrawdata`";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
            echo'<tr>
                <td>'.$row['ID'].'</td>
                <td>'.$row['PaypalID'].'</td>
				<td>'.$row['PAytmID'].'</td>
				<td>'.$row['bankname'].'</td>
				<td>'.$row['bankbranch'].'</td>
				<td>'.$row['bankifsccode'].'</td>
                <td>'.$row['accountholdername'].'</td>
				<td>'.$row['accountnumber'].'</td></tr>
			
			';

		}
		
    }
    
}
?> 