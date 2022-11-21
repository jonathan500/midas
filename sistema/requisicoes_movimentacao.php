<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;


switch ($_POST['acao']) {
    case 'inserir':
        $inserir_movimentacao = $midasSistema->inserir('midas_movimentacoes', '', '');

        $exec_inserir_movimentacao = $midasSistema->executar($inserir_movimentacao);

        if (mysqli_affected_rows($GLOBALS_['conexao']) > 0) {
            $retorno['dados'] = '';
            $retorno['erro']  = 'N';
            $retorno['mensagem'] = 'Dados inseridos com sucesso!';
        } else {
            $retorno['dados'] = '';
            $retorno['erro'] = 'S';
            $retorno['mensagem'] = 'Erro ao inserir os dados, favor tentar novamente mais tarde';
        }
        break;
    default:
        $retorno['dados'] = '';
        $retorno['erro'] = 'S';
        $retorno['mensagem'] = 'Erro ao inserir os dados, favor tentar novamente mais tarde';

        break;
}
