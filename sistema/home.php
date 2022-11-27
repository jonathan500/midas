<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

$logado = $midasSistema->logado();

if ($logado) {
    $movimentacoes = $midasSistema->retornaMovimentacoes($_SESSION['usuario_id']);
    $valores = $midasSistema->graficosGerador($movimentacoes[0]);
    $datas = $midasSistema->graficosGerador($movimentacoes[1]);
    $valores_2 = $midasSistema->retornaFaturamentoDespesaLucro();

    $conta = (float)$valores_2['receita'] + (float)$valores_2['despesa'];

    $meta = $midasSistema->metamaisproxima($conta);
    // print_r($meta);
    // exit;
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
        <title>Midas - Home</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
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
                            <a href="#">
                                <i class='bx bxs-home-alt-2 icon'></i>
                                <span class="text nav-text">Home</span>
                            </a>
                        </li>
                        <!-- <li class="nav-list">
                            <a href="<?php //print($midasSistema->retornaInicio()); ?>midas/sistema/dashboards.php">
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
                                <h3 class="text">Bem vindo! <?php print($_SESSION['usuario_nome']) ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="graficos">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 centralizador">
                                    <h4 style="color:#513DD9;">Faturamento</h4>
                                    <p>Durante o uso do App foi faturado um total de R$<?php print($midasSistema->formatarvalor2($valores_2['faturamento']))?> </p>
                                </div>
                                <div class="col-md-4 centralizador">
                                    <h4 style="color:#FF0000;">Despesas</h4>
                                    <p>As despesas durante o uso do App foram um total de R$<?php print($midasSistema->formatarvalor2($valores_2['despesa']))?></p>
                                </div>
                                <div class="col-md-4 centralizador">

                                    <h4 style="color:#2994F2;">Saldo</h4>
                                    <p>Por fim obtvemos um saldo total de R$ <?php print($midasSistema->formatarvalor2($conta));?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="receita"></canvas>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="metas"></canvas>
                        </div>
                    </div>

                </div>
        </section>
        <script src="../global.js"></script>
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php print($datas) ?>,
                    datasets: [{
                        label: 'Valor das movimentações',
                        data: <?php print($valores) ?>,
                        borderWidth: 1,
                        backgroundColor: 'blue'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        // Change options for ALL labels of THIS CHART
                        datalabels: {
                            color: '#000000'
                        }
                    },
                    aspectRatio: 10 / 2
                }
            });

            const metas = document.getElementById('metas');
            let dados = {
                datasets: [{
                    // cria-se um vetor data, com os valores a ser dispostos no gráfico
                    data: ['<?php print_r($meta['meta_valor'])?>'],
                    // cria-se uma propriedade para adicionar cores aos respectivos valores do vetor data
                    backgroundColor: ['#00FFB2']
                }],
                // cria-se legendas para os respectivos valores do vetor data
                labels: ['<?php print_r($meta['meta_nome'])?>']
            };
            let opcoes = {
                cutoutPercentage: 40,
                aspectRatio: 4 / 2
            };
            new Chart(metas, {
                type: 'pie',
                data: dados,
                options: opcoes
            });

            const receita = document.getElementById('receita');
            let dados2 = {
                datasets: [{
                    // cria-se um vetor data, com os valores a ser dispostos no gráfico
                    data: ['<?php print($midasSistema->formatarvalor($valores_2['despesa']));?>', '<?php print($midasSistema->formatarvalor($valores_2['faturamento']))?>'],
                    // cria-se uma propriedade para adicionar cores aos respectivos valores do vetor data
                    backgroundColor: ['#FF0000', '#513DD9']
                }],
                // cria-se legendas para os respectivos valores do vetor data
                labels: ['Faturamento', 'Despesa']
            };
            let opcoes2 = {
                cutoutPercentage: 40,
                aspectRatio: 6 / 2
            };
            new Chart(receita, {
                type: 'pie',
                data: dados2,
                options: opcoes2
            });
        </script>
    </body>

    </html>
<?php
} else {
    $_SESSION['logado'] = false;
    header('Location: login.php');
}
?>