<?php
include 'core/main.php';
$userid = $_SESSION['id'];
$wallet = $getFromU->getwalletdata($userid);
if ($getFromU->logedin() === false) {
    header('Location: login.php');
}
@var_dump($_SESSION);
if (isset($_POST['logout'])) {
    $getFromU->logout();
}if(isset($_POST['submit'])){
    $option  = $_POST['option'];
    $amount = $_POST['amount'];
    $id = $_SESSION['id'];
    if($wallet->accountbal < $amount){
        $errormsg = 'Low Account Balence';
    }else{
        $previousbal = $wallet->accountbal;
        $afterbet = $previousbal - $amount;
        //$getFromU->update('wallet',$id,array(`accountbal` => $afterbet));
        $getFromG->playgame($afterbet,$id,$option,$amount);
        header('Location: index.php');
    }
}
?>

<head>
<title>Dice</title>
<link href="core/styles.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav>
        <form action="" method="post"><input type="submit" id="logout" name="logout" value="logout"></form>
    </nav>

    <br>
    <hr>
    <?php
    //$getFromG->createperiod();
    //$getFromG->calculateresult();
    $time = $getFromG->timer();

    ?>
    <div id="result" class="result"name="result"></div>
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js?"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script>
       function fetchdata(){
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: "id=",
            success: function(data, textStatus) {
                $(".result").html(data); 
                  
            },
            
        });
    }

    $(document).ready(function(){
    setInterval(fetchdata,1000);
    });
      
    </script>

   
    <fieldset>
        <legend>Dice Bet</legend>
        <form action="" method="post">
            <label for="option">option</label>
            <select class="form-select" aria-label="Default select example" name="option" id="option">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
                <option value="5">Five</option>
                <option value="6">Six</option>
            </select>
            <br>
            <label for="amounnt">amount</label>
            <input type="text" name="amount" id="amount">

            <input type="submit" name="submit" value="submit">
        </form>
    </fieldset>

    <hr>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Your Bets
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Period Id</th>
                            <th>Bet Amount</th>
                            <th>Bet Option</th>
                            <th>result</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $getFromU->gamehistory($userid);?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <hr>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            History
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Period Id</th>
                            <th>result</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $getFromG->showgamehistory();?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>