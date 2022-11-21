<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midas - Login</title>
</head>
<body>
    <form action="log_login.php" method="post">
    <?php
        if(!empty($_SESSION['erro'])  && isset($_SESSION['erro'])){
    ?>
            <h1>
                <?php 
                    print($_SESSION['erro']);
                ?>
            </h1>
    <?php
        }
    ?>
    <input type='text' id='username' name='username'>
    <input type="password" id = 'password' name = 'password'>
    <button type = 'submmit'>entrar</button>
    </form>
</body>
</html>
<?php

?>