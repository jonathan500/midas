<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

switch ($_POST['acao']) {
    case 'inserir':
        $valor = str_replace(',','.',$_POST['valor']);
        $inserir_meta = $midasSistema->inserir(
        'midas_metas',
        '
        meta_usuario_id,
        meta_nome,
        meta_descricao,
        meta_data,
        meta_valor
        ',
            '\''.$_SESSION['usuario_id'].'\',
             \''.$_POST['nome'].'\',
             \''.$_POST['descricao'].'\',
             \''.$_POST['date'].'\','
             . $valor
        );

        // print_r($inserir_meta);exit;
        $exec_inserir_meta = $midasSistema->executar($inserir_meta);

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
            '*',
            'midas_metas',
            'meta_usuario_id = \'' . $_SESSION['usuario_id'] . '\''
        );

        $exec_consultar_dados = $midasSistema->executar($consultar_dados);
        $linhas = '';
        if (mysqli_num_rows($exec_consultar_dados) > 0) {
            while ($resultado = mysqli_fetch_assoc($exec_consultar_dados)) {

                $linhas .= '<div id="meta">';
                $linhas .= '<div class="meta_nome"><p class="mar-pad-0 fs-1">'.$resultado['meta_nome'].'</p></div>';
                $linhas .= '<div class="meta_valor"><p class="mar-pad-0 fs-1 text-end">R$ '.number_format($resultado['meta_valor'],2,",",".").'</p></div>';
                $linhas .= '<div class="meta_descricao"><p class="mar-pad-0 fs-14px">'.$resultado['meta_descricao'].'</p></div>';
                $linhas .= '<div class="meta_data"><p class="mar-pad-0 fs-14px text-end"><b>Conclusão em:</b> '.$midasSistema->converteDatatela($resultado['meta_data']).'</p></div>';
                $linhas .= '</div>';
            }
            $retorno['dados'] = $linhas;
            $retorno['erro'] = 'N';
        } else {
            $retorno['dados'] = '';
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
