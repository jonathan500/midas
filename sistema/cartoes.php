<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

$logado = $midasSistema->logado();

if ($logado) {


    $bandeiras_cartoes = $midasSistema->consultar('*', 'midas_bandeiras');
    $exec_bandeiras_cartoes = $midasSistema->executar($bandeiras_cartoes);
    $opcoes_bandeiras = '';

    while ($re_exec_bandeiras_cartoes = mysqli_fetch_assoc($exec_bandeiras_cartoes)) {
        $opcoes_bandeiras .= '<option value="' . $re_exec_bandeiras_cartoes['bandeira_id'] . '">' . $re_exec_bandeiras_cartoes['bandeira_descricao'] . '</option>';
    }

?>
    <!DOCTYPE html>

    <html lang="en">

    <head>
        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="shortcut icon" href="../logo.svg" type="image/x-icon" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Midas - Cartões</title>
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
                        <!-- <li class="nav-list">
                            <a href="<?php // print($midasSistema->retornaInicio()); ?>midas/sistema/dashboard.php">
                                <i class='bx bxs-pie-chart-alt-2 icon'></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li> -->
                        <li class="nav-list">
                            <a href="<?php print($midasSistema->retornaInicio()); ?>midas/sistema/movimentacao.php">
                                <i class='bx bxs-wallet icon'></i>
                                <span class="text nav-text">Movimentações</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="#">
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
                        <a href="<?php $midasSistema->retornaInicio() ?>/midas/sistema/sair.php">
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
                                <h3 style="text-align:center;" class="text">Cartões</h3>
                            </div>
                        </div>
                        <div class="form-gruop">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="Descrição" class="form-label control">Nome cartão:</label>
                                    <input type="text" name="descricao" id="descricao" class="form-control" placeholder="Aqui vocë pode colocar um identificador para o seu cartão..." />
                                </div>
                                <div class="col-md-2">
                                    <label for="Data" class="form-label">Data de validade:</label>
                                    <input type="date" name="data" id="data" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="bandeira" class="form-label control">Bandeira:</label>
                                    <select name="bandeira" id="bandeira" class="form-select control">
                                        <option value="---">Selecione um cartão</option>
                                        <?php
                                        print($opcoes_bandeiras);

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">

                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <button class="btn btn-primary btn-new-primary" onclick="cadastrar();">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>

                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="text-align:center;" class="text">Listagem de cartões</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table class="table">
                                    <thead>
                                        <tr style="text-align:center;">
                                            <th>Apelido</th>
                                            <th>Bandeira</th>
                                            <th>Data de validade</th>
                                        </tr>
                                    </thead>
                                    <tbody id='cartoes'></tbody>

                                </table>
                            </div>
                            <div class="col-md-1">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>

        </section>
        <script src="../global.js"></script>
        <script>
            $(document).ready(function() {
                consultar();
            });

            function cadastrar() {
                $.ajax({
                        url: "requisicoes_cartoes.php",
                        type: 'post',
                        data: {
                            acao: 'cadastrar',
                            descricao: $('#descricao').val(),
                            data_validade: $('#data').val(),
                            bandeira: $('#bandeira').val()
                        },
                        dataType: "json"
                    }).done(function(json) {
                        if (json.erro == 'S') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: json.mensagem,
                                confirmButtonText: 'Ok',
                                confirmButtonColor: 'red'
                            })
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: json.mensagem,
                                confirmButtonText: 'Ok',
                                confirmButtonColor: 'red'
                            }).then((result) => {
                                limpar();
                                consultar();
                            })
                        }
                    })
                    .fail(function(jqXHR, textStatus, msg) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ocoreeu um erro ao tentar registrar os dados, favor tente novamente mais tarde',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: 'red'
                        })
                    });
            }

            function limpar() {
                $('#descricao').val('');
                $('#data').val('');
                $('#bandeira').val('');
            }

            function consultar() {
                $.ajax({
                    url: "requisicoes_cartoes.php",
                    type: 'post',
                    data: {
                        acao: 'listar'
                    },
                    dataType: "json"
                }).done(function(json) {
                    $('#cartoes tr').remove();
                    $('#cartoes').append(json.dados);

                })
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