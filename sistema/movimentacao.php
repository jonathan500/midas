<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

$logado = $midasSistema->logado();

if ($logado) {

?>
    <!DOCTYPE html>

    <html lang="en">

    <head>
        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../logo.svg" type="image/x-icon" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Midas - Movimentações</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../global.css">

    </head>

    <body>
        <nav class="sidebar close">
            <header class='header-side'>
                <div class="image-text">
                    <span class="image">
                        <img src="../logo.svg" alt="logo">
                    </span>
                    <div class="text header-text">
                        <span class="name"><?php print_r($_SESSION['usuario_nome']); ?></span>
                        <span class="profession"><?php print_r($_SESSION['usuario_email']) ?></span>
                    </div>
                </div>
                <i class="bx bx-chevron-right toggle"></i>
            </header>
            <div class="menu-bar">
                <div class="menu">
                    <ul class="menu-links">
                        <li class="nav-list">
                            <a href="<?php print($midasSistema->retornaInicio()); ?>midas/sistema/home.php">
                                <i class='bx bxs-home-alt-2 icon'></i>
                                <span class="text nav-text">Home</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="<?php print($midasSistema->retornaInicio()); ?>midas/sistema/dashboard">
                                <i class='bx bxs-pie-chart-alt-2 icon'></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="#">
                                <i class='bx bxs-wallet icon'></i>
                                <span class="text nav-text">Movimentações</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="<?php print($midasSistema->retornaInicio()); ?>midas/sistema/cartoes.php">
                                <i class='bx bx-credit-card-alt icon'></i>
                                <span class="text nav-text">Cartões</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="<?php print($midasSistema->retornaInicio()); ?>midas/sistema/metas.php">
                                <i class='bx bx-target-lock icon'></i>
                                <span class="text nav-text">Metas</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="bottom-content">
                    <li class="nav-list">
                        <a href="<?php $midasSistema->retornaInicio()?>/midas/sistema/sair.php">
                            <i class='bx bx-log-out-circle icon'></i>
                            <span class="text nav-text">Sair</span>
                        </a>
                    </li>
                    <li class="mode">
                        <div class="moon-sun">
                            <i class="bx bx-moon icon moon"></i>
                            <i class="bx bx-sun icon sun"></i>
                        </div>
                        <span class="mode-text text">
                            Dark Mode
                        </span>
                        <div class="toggle-switch">
                            <span class="switch">
                            </span>
                        </div>
                    </li>
                </div>
            </div>
        </nav>
        <section class="home">
            <div class="conteiner-fluid">
                <div class="row ">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="text-align:center;" class="text">Movimentações</h3>
                            </div>
                        </div>
                        <div class="form-gruop">
                            <div class="row">

                                <div class="col-md-12">
                                    <label for="Descrição" class="form-label control">Descrição:</label>
                                    <input type="text" name="descricao" id="descricao" class="form-control" placeholder="Descrição da compra..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Data" class="form-label">Data:</label>
                                    <input type="date" name="data" id="data" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="Valor" class="form-label control">Valor da movimentação</label>
                                    <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor da movimentação...">
                                </div>
                                <div class="col-md-1" style="padding-top: 32px">
                                    <button class="btn btn-danger btn-new-primary" onclick="negativo()">
                                        <i class='bx bxs-upvote bx-rotate-180 icon'></i>

                                    </button>
                                </div>
                                <div class="col-md-1" style="padding-top: 32px">
                                    <button class="btn btn-success btn-new-primary" onclick="positivo();">
                                        <i class='bx bxs-upvote icon'></i>
                                    </button>
                                </div>
                                <input type="text" name="sinal" id="sinal" val="" hidden>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cartao" class="form-label control">Cartão</label>
                                    <select name="cartao" id="cartao" class="form-select control">
                                        <option value="---">Selecione um cartão</option>
                                        <?

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="categoria" class="form-label">Categoria</label>
                                    <select name="categoria" id="categoria" class="form-select control">
                                        <option value="----">Selecione uma categoria</option>
                                        <?php

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <button class="btn btn-secondary btn-new-primary" onclick="limpar();">
                                        Cancelar
                                    </button>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <br>
                                    <button class="btn btn-primary btn-new-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            dsafdsfdsa
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../global.js"></script>
        <script>
            function positivo() {
                $('#sinal').val('positivo');
            }

            function negativo() {
                $('#sinal').val('negativo');
            }

            function cadastrar() {
                // $.ajax({
                //     url:"",

                // });
            }

            function limpar() {
                $('#sinal').val('');
                $('#descricao').val('');
                $('#data').val('');
                $('#valor').val('');
                $('#cartao').val('');
                $('#categoria').val('');
            }
        </script>

    </body>

    </html>
<?php
} else {
    $_SESSION['logado'] = false;
    header('Location: login.php');
}
?>