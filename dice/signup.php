<?php 
include 'core/main.php';
if($getFromU->logedin() === true){
    header('Location: index.php');
}
if(isset($_POST['submit'])){
    $getFromU->sup($_POST['email'] , $_POST['pass']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <fieldset>
        <legend>Signup</legend>
        <form action="" method="post">
        <div>
            <div>
                <label for="email">Email</label>
            </div>
            <div><input type="email" name="email" id="email"></div>
            
        </div><br>
        <div>
            <div>
                <label for="email">Pass</label>
            </div>
            <div><input type="password" name="pass" id="pass"></div>
        </div><br>
        <div><input type="submit" name="submit" value="submit"></div></form>
    </fieldset>
</body>
</html>