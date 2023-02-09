<?php
class DiceGame extends User{
    protected $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function createperiod(){
        date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
        $starttime = date('Y-m-d h:i:sa');
        $time =strtotime(date('Y-m-d h:i:sa'))+180;
        //echo $time;
        //var_dump($time);
        //$time = date("Y-m-d h:i:sa",$time);
        $periodid = 'D'.date('Ymdhis'); 
        //echo $time;
        //echo $time;
        //echo date("h:i:sa",$time);
        $endtime = date("Y-m-d h:i:sa",$time); 
        $query = 'INSERT INTO `dicegame`(`periodid`, `start`, `end`) VALUES (:periodid , :starttime , :endtime)';
		$stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':periodid', $periodid, PDO::PARAM_STR);
		$stmt->bindValue(':starttime', $starttime, PDO::PARAM_STR);
		$stmt->bindValue(':endtime', $endtime, PDO::PARAM_STR);
		$stmt->execute();
		//echo $periodid;
        //echo $time;
    }
    public function timer(){
        $sql = 'SELECT * FROM `dicegame` ORDER BY id DESC LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $starttime = $result->start;
        $endtime  = $result->end;
        //echo $starttime.'<br>'.$endtime;
        $difference = strtotime($endtime) - strtotime($starttime);
        //echo floor($difference / (60)).'<br>';
        date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
        $presenttime = date('Y-m-d h:i:sa');
        $diff = strtotime($endtime) - strtotime($presenttime);
        //$diff = strtotime($diff);
        return $diff;

    }
    public function calculateresult(){
        $sql = 'SELECT * FROM `dicegame` ORDER BY id DESC LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        (int)$id  = (int)$result->periodid;
        $array =array('option1' => $result->option1, 'option2' => $result->option2, 'option3' => $result->option3,'option4' => $result->option4, 'option5' => $result->option5, 'option6' => $result->option6);
        $nonzerooptions = array();
        foreach ($array as $option => $optionvalue){  
            if($optionvalue != 0){
                $nonzerooptions += array($option => $optionvalue);
            }
        }  
        if(count($nonzerooptions) >= 2 ){
           $finalresult = array_search(min($nonzerooptions), $nonzerooptions);
            if($finalresult == 'option1'){
                $winner = '1';
            }if($finalresult == 'option2'){
                $winner = '2';
            }
            if($finalresult == 'option3'){
                $winner = '3';
            }
            if($finalresult == 'option4'){
                $winner = '4';
            }if($finalresult == 'option5'){
                $winner = '5';
            }
            if($finalresult == 'option6'){
                $winner = '6';
            }
            $sql = "UPDATE `dicegame` SET `result`={$winner} ORDER BY id DESC LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }else{
            $winner = '0';
            echo 'bet canclelled<br>';
            $sql = "UPDATE `dicegame` SET `result`='bet canclelled' ORDER BY id DESC LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        return $winner;
    }
    public function showgamehistory(){
        $sql = 'SELECT * FROM `dicegame` ORDER BY id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $count = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $count = $count+1;
           echo  '<tr>
           <td>'.$count.'</td>
           <td>'.$row['periodid'].'</td>
           <td>'.$row['result'].'</td>
           </tr>';
        }
    }
    public function updatehistory($winner){
        $sql = "SELECT * FROM `dicegame` ORDER BY `id` DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $periodid = $row->periodid;
        $sql = "SELECT * FROM `dicehistory` WHERE `periodid` = {$periodid}";
        $id = $this->pdo->prepare($sql);
        $id->execute();
        while($row = $id->fetch(PDO::FETCH_ASSOC)){
            if($row['beton'] == $winner){
                $asd = $winner.'WIN';

                $sql = "UPDATE `dicehistory` SET `result`=`{$asd}` WHERE `id`={$row['id']}";
                $func = $this->pdo->prepare($sql);
                $func->execute();

                $betamount = $row['betamount'];
                $winningamt = $betamount + $betamount;

                $walletsel = "SELECT * FROM `wallet` WHERE `id` = {$row['betby']}";
                $wallet = $this->pdo->prepare($walletsel);
                $wallet->execute();
                $walletdata = $wallet->fetch(PDO::FETCH_OBJ);

                $previousbal = $walletdata->accountbal;
                $totalbal = $previousbal + $winningamt;

                $precaptha = $walletdata->capthaearnings;
                $capthaamt = $precaptha + $betamount;

                $prewinningamt = $walletdata->winning;
                $winn = $prewinningamt + $betamount;

                $sql3 = "UPDATE `wallet` SET `accountbal`={$totalbal} WHERE `id` = {$walletdata->id} ";
                $stmt1 = $this->pdo->prepare($sql3);
                $stmt1->execute();
                $sql3 = "UPDATE `wallet` SET `capthaearnings`={$capthaamt} WHERE `id` = {$walletdata->id} ";
                $stmt1 = $this->pdo->prepare($sql3);
                $stmt1->execute();
                $sql3 = "UPDATE `wallet` SET `winning`={$winn} WHERE `id` = {$walletdata->id} ";
                $stmt1 = $this->pdo->prepare($sql3);
                $stmt1->execute();
            }else{
                $asd = $winner.'Loose';
                $sql = "UPDATE `dicehistory` SET `result`='{$asd}' WHERE `id` = {$row['id']}";
                $func = $this->pdo->prepare($sql);
                $func->execute();
            }
        }
    }
    public function playgame($id,$option,$betamount){
        $betamount = (int)$betamount;
        $id = (int)$id;
        $sql = "SELECT * FROM `wallet` WHERE `id` = {$id}";
        $stmt2 = $this->pdo->prepare($sql);
        $stmt2->execute();

        $wallet = $stmt2->fetch(PDO::FETCH_OBJ);
        $afterbet = $wallet->capthaearnings - $betamount;
        $accountbalance = $wallet->accountbal - $betamount;
        $spent = $wallet->spentombet + $betamount;
        
        $sql = "UPDATE `wallet` SET `capthaearnings`={$afterbet}  WHERE `id` = {$id}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();


        $sql = "UPDATE `wallet` SET `spentonbet`={$spent}  WHERE `id` = {$id}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $sql = "UPDATE `wallet` SET `accountbal` = {$accountbalance} WHERE `id` = {$id}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $sql = "SELECT * FROM `dicegame` ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $id = (int)$id;
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $pid = $result->id;
        $periodid = $result->periodid;
        $betamount = (int)$betamount;
        if($option == '1'){
            $amount = $result->option1 + $betamount;
            
            $sql = "UPDATE `dicegame` SET `option1` = {$amount} WHERE `id` = {$pid}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        if($option == '2'){
            $amount = $result->option2 + $betamount;
            $sql = "UPDATE `dicegame` SET `option2` = {$amount} WHERE `id` = {$pid}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
        }
        if($option == 3){
            $amount = $result->option3 + $betamount;
            $sql = "UPDATE `dicegame` SET `option3` = {$amount} WHERE `id` = {$pid}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        if($option == '4'){
            $amount = $result->option4 + $betamount;
            $sql = "UPDATE `dicegame` SET `option4` = {$amount} WHERE `id` = {$pid}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        if($option == '5'){
            $amount = $result->option4 + $betamount;
            $sql = "UPDATE `dicegame` SET `option5` = {$amount} WHERE `id` = {$pid}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        if($option == '6'){
            $amount = $result->option6 + $betamount;
            $sql = "UPDATE `dicegame` SET `option6` = {$amount} WHERE `id` = {$pid}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        //needed toadd in history table
        $sql = "INSERT INTO `dicehistory`  (`periodid`,`beton`,`betamount`,`betby`) VALUES (:peid,:bon,:bet,:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':peid',$periodid,PDO::PARAM_INT);
        $stmt->bindParam(':bon',$option,PDO::PARAM_STR);
        $stmt->bindParam(':bet',$amount,PDO::PARAM_INT);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();        
    }
}
?>