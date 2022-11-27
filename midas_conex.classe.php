<?php
session_start();

class MyMidas
{
    function __construct()
    {
        $host = "localhost";
        $user = "root";
        $password = "";
        $base = 'midas';

        $conexao = new mysqli($host, $user, $password, $base);
        if ($conexao) {
            $GLOBALS['conexao'] = $conexao;
        } else {
            $GLOBALS['conexao'] = 'falha';
        }
    }

    //consultar
    function consultar($colunas, $tabela, $condicoes = '')
    {

        if (empty($condicoes)) {
            $query  = 'SELECT ' . $colunas . ' FROM ' . $tabela;
        } else {
            $query  = 'SELECT ' . $colunas . ' FROM ' . $tabela . ' WHERE ' . $condicoes;
        }

        return $query;
    }

    //deletar 
    function deletar($tabela, $condicoes)
    {
        $query  = 'DELETE FROM ' . $tabela . ' WHERE ' . $condicoes;
        return $query;
    }

    // atualizar
    function atualizar($tabela, $alteracoes, $condicoes)
    {
        $query  = 'UPDATE ' . $tabela . ' SET ' . $alteracoes . ' WHERE ' . $condicoes;
        return $query;
    }

    function inserir($tabela, $colunas, $valores)
    {
        $query = 'INSERT INTO ' . $tabela . '(' . $colunas . ')' . ' VALUES (' . $valores . ')';
        return $query;
    }

    // executar
    function executar($query)
    {
        if ($GLOBALS['conexao'] == 'falha') {
            return false;
        } else {
            $resultado = mysqli_query($GLOBALS['conexao'], $query);
        }
        return $resultado;
    }

    function retornaInicio()
    {
        $caminho = "$_SERVER[REQUEST_URI]";
        $caminho = explode('/', $caminho);
        $inicio = '';
        foreach ($caminho as $key => $link) {
            if (!empty($link) && $link != 'midas')
                $inicio .= '../';
        }

        return $inicio;
    }

    function logado()
    {
        if ($_SESSION['logado'] != true || !isset($_SESSION['logado'])) {
            $_SESSION['logado'] = false;
            header('Location: ' . $this->retornaInicio() . 'midas/sistema/login.php');
        } else {
            return true;
        }
    }

    function sair()
    {
        if ($_SESSION['logado']) {
            session_destroy();
            header('Location: ../sistema/login.php');
        } else {
            session_destroy();
            header('Location: ../sistema/login.php');
        }
    }

    function formatarvalor($valor)
    {
        return str_replace(',', '.', $valor);
    }

    function formatarvalor2($valor){
        $valor = number_format($valor,2,",",".");
        return $valor;
    }
    
    function converteDataTela($data)
    {

        $data = explode('-', $data);
        $data = array_reverse($data);
        return $data[0] . '/' . $data[1] . '/' . $data[2];
    }

    function retornaMovimentacoes($usuario)
    {
        $movimentacoes = $this->consultar('SUM(a.movimentacao_valor) as valor_dia,a.movimentacao_data', '
        midas_movimentacoes a LEFT JOIN midas_usuarios b ON b.usuario_id = a.movimentacao_usuario_id', '
        b.usuario_id = \'' . $usuario . '\' GROUP BY a.movimentacao_data ORDER BY a.movimentacao_data asc');
        $exec_movimentacoes = $this->executar($movimentacoes);
        // $resultado = mysqli_fetch_all($exec_movimentacoes);
        $valores = [];
        $datas = [];
        while ($resultado_movimentacoes = mysqli_fetch_assoc($exec_movimentacoes)) {
            $valores[] .= $resultado_movimentacoes['valor_dia'];
            $datas[] .= $this->converteDataTela($resultado_movimentacoes['movimentacao_data']);
        }
        $movimentacoes_1[0] = $valores;
        $movimentacoes_1[1] = $datas;
        return $movimentacoes_1;
        // return $datas;
    }
    function retornaFaturamentoDespesaLucro()
    {
        $consultar_valores = $this->consultar('
            faturamento,
            despesa,
            receita', '
                (
                    SELECT
                        SUM(movimentacao_valor) AS faturamento
                    FROM
                        midas_movimentacoes a
                        LEFT JOIN midas_usuarios b ON b.usuario_id = a.movimentacao_usuario_id
                    WHERE
                        b.usuario_id = \'' . $_SESSION['usuario_id'] . '\' > 0
                ) AS tabela1
                JOIN (
                    SELECT
                        SUM(movimentacao_valor) AS despesa
                    FROM
                        midas_movimentacoes a
                        LEFT JOIN midas_usuarios b ON b.usuario_id = a.movimentacao_usuario_id
                    WHERE
                        b.usuario_id = \'' . $_SESSION['usuario_id'] . '\'
                        AND a.movimentacao_valor < 0
                ) AS tabela2
                JOIN (
                    SELECT
                        SUM(movimentacao_valor) AS receita
                    FROM
                        midas_movimentacoes a
                        LEFT JOIN midas_usuarios b ON b.usuario_id = a.movimentacao_usuario_id
                    WHERE
                        b.usuario_id = \'' . $_SESSION['usuario_id'] . '\'
                ) AS tabela3');
                $exec_consultar_valores = $this->executar($consultar_valores);
                $resultado = mysqli_fetch_assoc($exec_consultar_valores);
                return $resultado;
    }

    function metamaisproxima($valor){
        $query_dados = $this->consultar('
        * ','midas_metas','meta_usuario_id = \''.$_SESSION['usuario_id'].'\' ORDER BY meta_valor ASC');
        $exe_query_dados = $this->executar($query_dados);
        $cont = 1;
        $resultado_2 = [];
        while($resultado = mysqli_fetch_assoc($exe_query_dados)){
            $conta = $resultado['meta_valor'] - $valor;

            if($cont==1){
                $menor = $conta;
                $resultado_2 = $resultado;
            }
            if($menor > $conta){
                $menor = $conta;
                $resultado_2 = $resultado;
            }
            if($conta>0){
                $resultado_2['meta_concluida'] = 100;
                $resultado_2['meta_falta'] = '';
            }else{
                $resultado_2['meta_concluida'] = $valor/$conta * 100;
                $resultado_2['meta_falta'] = 100 - $resultado_2['meta_concluida'];
            }
            $cont=2;
        }
        return $resultado_2;

    }
    function graficosGerador($dados)
    {
        // $dados = array_count_values($dados);
        $concatena = '';
        $contador1 = count($dados) - 1;
        $contador2 = 0;
        $concatena = '[';
        foreach ($dados as $key => $value) {
            if ($contador2 == $contador1) {
                $concatena .= '\'' . $value . '\'';
            } else {
                $concatena .= '\'' . $value . '\',';
            }

            $contador2 += 1;
        }
        $concatena .= ']';
        return $concatena;
    }
}
