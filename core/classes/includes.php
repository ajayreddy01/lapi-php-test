<?php
class includes{
    public function scripts(){
        echo '
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    
       
        <script src="../assets/demo/datatables-demo.js"></script>
        <script src="../assets/demo/datatables-demo.js"></script>
        ';
    }

    public function localscripts(){

        echo '
        <link href="../core/css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="../core/assets/DataTables-1.10.24/css/dataTables.bootstrap4.css"/>
        
        <script type="text/javascript" src="../core/jslibrary/jquery3.3.1.min.js"></script>
        <script type="text/javascript" src="../core/jslibrary/jquery1.12.1-ui.min.js"></script>
        
        
        <script type="text/javascript" src="../core/js/datatables-demo.js"></script>
        
        <script type="text/javascript" src="../core/assets/jQuery-1.12.4/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="../core/assets/jQuery-1.12.4/jquery-1.12.4.min.js"></script>
        <script type="text/javascript" src="../core/assets/DataTables-1.10.24/js/jquery.dataTables.js"></script>
        
        <script type="text/javascript" src="../core/assets/DataTables-1.10.24/js/dataTables.bootstrap4.js"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <!--bootstrap-->
        <link href="../core/bootstrap/css/bootstrap-grid.css" rel="stylesheet" />
        <link href="../core/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet" />
        <link href="../core/bootstrap/css/bootstrap-reboot.css" rel="stylesheet" />
        <link href="../core/bootstrap/css/bootstrap-reboot.min.css" rel="stylesheet" />
        <link href="../core/bootstrap/css/bootstrap.css" rel="stylesheet" />
        <link href="../core/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

        <!--bootstrap-->

        <!--Fontawsome-->
        <script src="../core/fontawesome/js/all.js"></script>
        <!--fontawsome-->
        <script type="text/javascript" src="../core/js/scripts.js?"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

        ';
    }

    public function sidenav(){
        echo '
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="captha.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-retweet"></i></div>
                            Captha
                        </a>
                        <a class="nav-link" href="referals.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-user-plus"></i></div>
                            Referals
                        </a>
                        <div class="sb-sidenav-menu-heading">Games</div>
                        <a class="nav-link" href="dice.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-dice-one"></i></div>
                            Dice
                        </a>
                        <a class="nav-link" href="colours.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-palette"></i></i></div>
                            Colours
                        </a>
                        <div class="sb-sidenav-menu-heading">History</div>
                        <a class="nav-link" href="dicehistory.php">
                            <div class="sb-nav-link-icon"></div>
                            Dice History
                        </a>
                        <a class="nav-link" href="colourshistory.php">
                            <div class="sb-nav-link-icon"></div>
                            Colours History
                        </a>
                    </div>
                </div>
                
            </nav>
        </div>
        ';
    }

    public function topnav(){
        echo '    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="../user/index.php">Paid For Work</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="wallet.php"><i class="fas fa-wallet"></i></i>Withdraw</a>
                    <a class="dropdown-item" href="support.php"><i class="fas fa-certificate"></i></i>Support</a>  
                    <div class="dropdown-divider"></div>  
                    <a class="dropdown-item" href="../logout.php"><i class="fas fa-exit"></i></i>Logout</a>
                </div>
            </li>
        </ul></nav>';
    }

    public function footer(){
        echo '<footer class="py-4 bg-light mt-auto">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright  &copy; Paid For Work &trade; '.date('Y').'</div>
                <div>
                    <a href="../privacypolicy.php">Privacy Policy</a>
                    &middot;
                    <a href="../t&c.php">Terms &amp; Conditions</a>
                </div>
            </div>
        </div></footer>';
    }
}
?>