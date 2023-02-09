<?php
/* 
	Developed By 
		->Ajay Reddy Chinthala(IG::@ajay_reddy_01)
		->Sohail Ashraf (IG::@sohail__ashraf)

*/
class Wallet extends User{

	protected $pdo;
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
    }
    public function getwalletdata($ID){
        $stmt = $this->pdo->prepare('SELECT * FROM `wallet` WHERE `ID` = :ID');
		$stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function gettotalearninndgsbyid($id){
		$query="SELECT `total_earnings` FROM `wallet` WHERE `ID` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $id, PDO::PARAM_STR);
		$stmt->execute();
		$totalearnings = $stmt->fetch(PDO::FETCH_OBJ);
		$data = $totalearnings->total_earnings;
		return $data;
	}
	public function getwithdrawdatabyid($id){
		$query = "SELECT * FROM `withdrawdata` WHERE `ID` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $id, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function withdraw($ID,$amount,$method){
		date_default_timezone_set("Asia/Calcutta");
		$date = date('d/m/y');
		$time= date("h:i:s");
		$remarks ='To Be Processed By Admin';
		$sts = 'Under Process';
		$transactionid = $ID.date("his").date("dmy");
		$transactionid = 'TNX'.date("ymd").date("sih").$ID.time();
		$query = 'INSERT INTO `transactions`(`ID`, `date`, `time`, `amount`, `status`, `method`, `transactionID`, `remarks`) VALUES (:ID,:dat,:tim,:amount,:stat,:method,:transactionID,:remarks)';
		$stmt =$this->pdo->prepare($query);
		$stmt->bindValue(':ID',$ID,PDO::PARAM_INT);
		$stmt->bindValue(':dat',$date,PDO::PARAM_STR);
		$stmt->bindValue(':tim',$time,PDO::PARAM_STR);
		$stmt->bindValue(':amount',$amount,PDO::PARAM_INT);
		$stmt->bindValue(':stat',$sts,PDO::PARAM_STR);
		$stmt->bindValue(':method',$method,PDO::PARAM_STR);
		$stmt->bindValue(':transactionID',$transactionid,PDO::PARAM_STR);
		$stmt->bindValue(':remarks',$remarks,PDO::PARAM_STR);
		$stmt->execute();

		header('Location: ../user/index.php');
	}
	public function crttrnforinstalikes($ID,$amount){
		$method ='Insta Likes';
		date_default_timezone_set("Asia/Calcutta");
		$date = date('d/m/y');
		$time= date("h:i:s");
		$remarks ='To Be Processed By Admin';
		$sts = 'Under Process';
		$transactionid = $ID.date("his").date("dmy");
		$transactionid = date("ymd").date("sih").$ID.time();
		$query = 'INSERT INTO `transactions`(`ID`, `date`, `time`, `amount`, `status`, `method`, `transactionID`, `remarks`) VALUES (:ID,:dat,:tim,:amount,:stat,:method,:transactionID,:remarks)';
		$stmt =$this->pdo->prepare($query);
		$stmt->bindValue(':ID',$ID,PDO::PARAM_INT);
		$stmt->bindValue(':dat',$date,PDO::PARAM_STR);
		$stmt->bindValue(':tim',$time,PDO::PARAM_STR);
		$stmt->bindValue(':amount',$amount,PDO::PARAM_INT);
		$stmt->bindValue(':stat',$sts,PDO::PARAM_STR);
		$stmt->bindValue(':method',$method,PDO::PARAM_STR);
		$stmt->bindValue(':transactionID',$transactionid,PDO::PARAM_STR);
		$stmt->bindValue(':remarks',$remarks,PDO::PARAM_STR);
		$stmt->execute();
	}
	public function crttrnforinstafollow($ID,$amount){
		$method ='Insta Followers';
		date_default_timezone_set("Asia/Calcutta");
		$date = date('d/m/y');
		$time= date("h:i:s");
		$remarks ='To Be Processed By Admin';
		$sts = 'Under Process';
		$transactionid = $ID.date("his").date("dmy");
		$transactionid = date("ymd").date("sih").$ID.time();
		$query = 'INSERT INTO `transactions`(`ID`, `date`, `time`, `amount`, `status`, `method`, `transactionID`, `remarks`) VALUES (:ID,:dat,:tim,:amount,:stat,:method,:transactionID,:remarks)';
		$stmt =$this->pdo->prepare($query);
		$stmt->bindValue(':ID',$ID,PDO::PARAM_INT);
		$stmt->bindValue(':dat',$date,PDO::PARAM_STR);
		$stmt->bindValue(':tim',$time,PDO::PARAM_STR);
		$stmt->bindValue(':amount',$amount,PDO::PARAM_INT);
		$stmt->bindValue(':stat',$sts,PDO::PARAM_STR);
		$stmt->bindValue(':method',$method,PDO::PARAM_STR);
		$stmt->bindValue(':transactionID',$transactionid,PDO::PARAM_STR);
		$stmt->bindValue(':remarks',$remarks,PDO::PARAM_STR);
		$stmt->execute();
	}
	public function deductqmount($amt,$ID){
		
	}
}
?>