
<?php

?>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="global.js">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../logo.svg" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midas - Cadastre-se</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../global.css">
</head>

<body class="login">
    <div class="container-login">
        <div class="login-left">
            <img class="imagem-login" src="../wolrd.svg" alt="wolrd">
        </div>
        <div class="login-right">
            <div class="login-header">
                <h1>
                    Bem vindo ao Midas!
                </h1>
                <p>Por favor,para prossegui cadastre-se em nossa plataforma</p>
                <?php
                if (!empty($_SESSION['erro'])  && isset($_SESSION['erro'])) {
                ?>

                    <?php
                    print('<div class="alert alert-danger" role="alert">
                       ' . $_SESSION['erro'] . '
                     </div>');
                    ?>

                <?php
                }
                ?>
            </div>
            <form action="log_cadastro.php" class="login-form" method="post">
                <div class="form-gruop">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Nome</label>
                            <input class="form-control" type="text" id="name" name="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="text" id="username" name="username">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Senha</label>
                            <input class="form-control" type="password" id="password" name="password">
                        </div>
                    </div>

                    <div class="separacao">

                    </div>
                    <div class="row prabaixo">

                        <div class="col-md-5">
                            <button style="width: 100% !important;" class="btn btn-secondary btn-new-primar " type="button" onclick="location.href='login.php'">Reornar ao login</button>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <button style="width: 100% !important;" class="btn btn-primary btn-new-primar " type="submit">Cadastrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>