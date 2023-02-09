<?php
class games{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo =$pdo;
    }
    public function colourgameresult($period){
        $query = "SELECT * FROM `coloursgame` WHERE `period` = :code";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':code', $period, PDO::PARAM_STR);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $redamt = $row['redcolour'];
            $greenamt = $row['greencolour'];
            
        }
    } 
}
?>