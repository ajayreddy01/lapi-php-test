<?php
include 'core/main.php';
 //$getFromG->calculateresult();
 $time = $getFromG->timer();

 if($time <= 30){     
   $winner  = $getFromG->calculateresult();
   echo '<br>'.$winner;
   
 }
 if($time >= 0){
   echo  '<br>'.$time;
 }
 else{
   $getFromG->updatehistory($winner);
   $getFromG->createperiod();
 }

?>