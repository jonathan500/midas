<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

switch ($_POST['acao']) {
    case 'inserir':
        $valor = str_replace(',','.',$_POST['valor']);
        print($valor);
        exit;
        $inserir_movimentacao = $midasSistema->inserir(
            'midas_movimentacoes',
            '
        movimentacao_usuario_id,
        movimentacao_categoria_id,
        movimentacao_cartao_id,
        movimentacao_descricao,
        movimentacao_data,
        movimentacao_valor',
            $_SESSION['usuario_id'] . ',' .
                $_POST['categoria'] . ',' .
                $_POST['cartao'] . ', \'' .
                $_POST['descricao'] . '\',\'' .
                $_POST['date'] . '\',' .
                $_POST['valor']
        );

        $exec_inserir_movimentacao = $midasSistema->executar($inserir_movimentacao);

        if (mysqli_affected_rows($GLOBALS['conexao']) > 0) {
            $retorno['dados'] = '';
            $retorno['erro']  = 'N';
            $retorno['mensagem'] = 'Dados inseridos com sucesso!';
        } else {
            $retorno['dados'] = '';
            $retorno['erro'] = 'S';
            $retorno['mensagem'] = 'Erro ao inserir os dados, verifique se todos os campos foram preenchidos';
        }
        break;
    case 'listar':
        $consultar_dados = $midasSistema->consultar(
            'a.*, b.categoria_descricao as movimentacao_categoria, c.cartao_descricao as movimentacao_cartao',
            'midas_movimentacoes a LEFT JOIN midas_categorias b ON a.movimentacao_categoria_id = b.categoria_id LEFT JOIN midas_cartoes c ON a.movimentacao_cartao_id = c.cartao_id',
            'movimentacao_usuario_id = \'' . $_SESSION['usuario_id'] . '\''
        );
        $exec_consultar_dados = $midasSistema->executar($consultar_dados);
        $linhas = '';
        if (mysqli_num_rows($exec_consultar_dados) > 0) {
            while ($resultado = mysqli_fetch_assoc($exec_consultar_dados)) {
                $linhas .= '<tr>';
                $linhas .= '<td style="text-align: center">';
                $linhas .= $resultado['movimentacao_id'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: center">';
                $linhas .= $resultado['movimentacao_descricao'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: right">';
                $linhas .= $resultado['movimentacao_valor'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: center">';
                $linhas .= $resultado['movimentacao_data'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: center">';
                $linhas .= $resultado['movimentacao_categoria'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: center">';
                $linhas .= $resultado['movimentacao_cartao'];
                $linhas .= '</td>';
                $linhas .= '</tr>';
            }
            $retorno['dados'] = $linhas;
            $retorno['erro'] = 'N';
        } else {
            $retorno['dados'] = 'a';
            $retorno['erro'] = 'S';
            $retorno['mensagem'] = 'Erro ao consultar movimentações, favor tente novamente mais tarde';
        }
        break;

    default:
        $retorno['dados'] = '';
        $retorno['erro'] = 'S';
        $retorno['mensagem'] = 'Erro ao inserir os dados, favor tentar novamente mais tarde';

        break;
}

echo (json_encode($retorno));
