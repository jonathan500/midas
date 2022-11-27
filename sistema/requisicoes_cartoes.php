<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

switch ($_POST['acao']) {
    case 'listar':
        $consulta_cartoes = $midasSistema->consultar('a.*, b.bandeira_descricao as cartao_bandeira ', 'midas_cartoes a LEFT JOIN midas_bandeiras b ON a.cartao_bandeira_id = b.bandeira_id ', 'a.cartao_usuario_id =\'' . $_SESSION['usuario_id'] . '\' ORDER BY a.cartao_data_validade DESC');
        $ex_consulta_cartoes = $midasSistema->executar($consulta_cartoes);
        $linhas = '';
        if (mysqli_num_rows($ex_consulta_cartoes) > 0) {
            while ($re_exe_consulta_cartoes = mysqli_fetch_assoc($ex_consulta_cartoes)) {
                $linhas .= '<tr>';
                $linhas .= '<td style="text-align: left">';
                $linhas .= $re_exe_consulta_cartoes['cartao_descricao'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: left">';
                $linhas .= $re_exe_consulta_cartoes['cartao_bandeira'];
                $linhas .= '</td>';
                $linhas .= '<td style="text-align: center">';
                $linhas .= $midasSistema->converteDataTela($re_exe_consulta_cartoes['cartao_data_validade']);
                $linhas .= '</td>';
                $linhas .= '</tr>';
            }
            $retorno['dados'] = $linhas;
            $retorno['erro'] = 'N';
            $retorno['mensagem'] = 'Cartões consultados com sucesso';
        } else {
            $retorno['dados'] = '';
            $retorno['erro'] = 'S';
            $retorno['mensagem'] = 'Falha ao consultar cartões';
        }
        break;
    case 'cadastrar':
        $inserir_cartoes = $midasSistema->inserir(
            'midas_cartoes',
            'cartao_descricao,cartao_data_validade,cartao_bandeira_id,cartao_usuario_id',
            '\'' . $_POST['descricao'] . '\',
            \'' . $_POST['data_validade'] . '\',' .
                $_POST['bandeira'] . ',' .
                $_SESSION['usuario_id']
        );
        $exec_inserir_cartoes = $midasSistema->executar($inserir_cartoes);
        if (mysqli_affected_rows($GLOBALS['conexao']) > 0) {
            $retorno['dados'] = '';
            $retorno['erro'] = 'N';
            $retorno['mensagem'] = 'Cartão cadastrado com sucesso';
        } else {
            $retorno['dados'] = '';
            $retorno['erro'] = 'S';
            $retorno['mensagem'] = 'Erro ao cadastar o cartão';
        }
        break;
    default:
        $retorno['dados'] = '';
        $retorno['erro'] = 'S';
        $retorno['mensagem'] = 'Tipo de requisição inválida';
        break;
}

echo (json_encode($retorno));
