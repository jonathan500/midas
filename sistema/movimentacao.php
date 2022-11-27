<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

$logado = $midasSistema->logado();

if ($logado) {

    // consulta de categorias
    $consultar_categorias = $midasSistema->consultar('*', 'midas_categorias', 'categoria_situacao LIKE \'A\'');
    $exec_consultar_categorias = $midasSistema->executar($consultar_categorias);
    $opcoes_categorias = '';
    while ($re_exec_consultar_categorias = mysqli_fetch_assoc($exec_consultar_categorias)) {
        $opcoes_categorias .= '<option value="' . $re_exec_consultar_categorias['categoria_id'] . '">' . $re_exec_consultar_categorias['categoria_descricao'] . '</option>';
    }

    //consulta de cartoes do usuario
    $consulta_cartoes = $midasSistema->consultar('*', 'midas_cartoes', 'cartao_usuario_id = \'' . $_SESSION['usuario_id'] . '\'');
    $exec_consulta_cartoes = $midasSistema->executar($consulta_cartoes);
    $opcoes_cartoes = '';

    while ($re_exec_consulta_cartoes = mysqli_fetch_assoc($exec_consulta_cartoes)) {
        $opcoes_cartoes .= '<option value="' . $re_exec_consulta_cartoes['cartao_id'] . '">' . $re_exec_consulta_cartoes['cartao_descricao'] . '</option>';
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
                                    <input type="text" name="valor" id="valor" class="form-control" onkeyup="formatarMoeda();" placeholder="Valor da movimentação...">
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
                                        <?php
                                        print($opcoes_cartoes);

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="categoria" class="form-label">Categoria</label>
                                    <select name="categoria" id="categoria" class="form-select control">
                                        <option value="----">Selecione uma categoria</option>
                                        <?php
                                        print($opcoes_categorias);
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
                                    <button class="btn btn-primary btn-new-primary" onclick="cadastrar();">
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
            <br>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="text-align:center;" class="text">Listagem de movimentações</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th>Código da movimentação</th>
                                        <th>Descricao da movimentação</th>
                                        <th>Valor da movimentação R$</th>
                                        <th>Data da movimentação</th>
                                        <th>Movimentação Categoria</th>
                                        <th>Cartão utilizado</th>
                                    </tr>
                                </thead>
                                <tbody id='movimentacoes'></tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../global.js"></script>
        <script>
            $(document).ready(function() {
                consultar();
            });

            function positivo() {
                $('#sinal').val('positivo');
            }

            function negativo() {
                $('#sinal').val('negativo');
            }

            function cadastrar() {
                if (
                    $('#sinal').val() != '' & $('#descricao').val() != '' & $('#data').val() != '' & $('#valor').val() != '' & $('#cartao').val() != '' & $('#categoria').val() != ''
                ) {
                    $.ajax({
                            url: "requisicoes_movimentacao.php",
                            type: 'post',
                            data: {
                                acao: 'inserir',
                                descricao: $('#descricao').val(),
                                valor: $('#valor').val(),
                                date: $('#data').val(),
                                cartao: $('#cartao').val(),
                                sinal: $('#sinal').val(),
                                categoria: $('#categoria').val()
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
            }

            function limpar() {
                $('#sinal').val('');
                $('#descricao').val('');
                $('#data').val('');
                $('#valor').val('');
                $('#cartao').val('');
                $('#categoria').val('');
            }

            function consultar() {
                $.ajax({
                    url: "requisicoes_movimentacao.php",
                    type: 'post',
                    data: {
                        acao: 'listar'
                    },
                    dataType: "json"
                }).done(function(json) {
                    $('#movimentacoes tr').remove();
                    $('#movimentacoes').append(json.dados);
                });
            }

            function formatarMoeda() {
                var elemento = document.getElementById('valor');
                var valor = elemento.value;

                valor = valor + '';
                valor = parseInt(valor.replace(/[\D]+/g, ''));
                valor = valor + '';
                valor = valor.replace(/([0-9]{2})$/g, ",$1");

                if (valor.length > 6) {
                    valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, "$1,$2");
                }

                elemento.value = valor;
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