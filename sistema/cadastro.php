<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midas - Cadastro</title>
</head>
<body>
    <form action="log_cadastro.php" method="post">
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
        <input type = "password" id = 'confirmpassword' name = 'confirmpassword'>
        <input type = "text" id='name' name='name'>
        <button type = 'submmit'>Cadastrar</button>
    </form>
</body>
</html>
<?php

?>