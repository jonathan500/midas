<?php
session_start();

require('../midas_conex.classe.php');

$midasSistema = new MyMidas;
$consultar_usuario = $midasSistema->consultar('usuario_id','midas_usuarios','usuario_email LIKE \'%'.$_POST['username'].'%\'');

$exc_consultar_usuario = $midasSistema->executar($consultar_usuario);
if(mysqli_num_rows($exc_consultar_usuario) == 0){
    $novo_usuario = $midasSistema->inserir('midas_usuarios',
                            'usuario_email,usuario_senha,usuario_nome',
                            '\''.$_POST['username'].'\',
                             \''.$_POST['password'].'\',
                             \''.$_POST['name'].'\'');
    
    $exc_novo_usuario = $midasSistema->executar($novo_usuario);
    if(mysqli_affected_rows($GLOBALS['conexao']) == 1){
        $exc_consultar_usuario = $midasSistema->executar($consultar_usuario);
        if(mysqli_num_rows($exc_consultar_usuario) > 0){
            $re_exc_consultar_usuario = mysqli_fetch_assoc($exc_consultar_usuario);
            $_SESSION['usuario_id'] =  $re_exc_consultar_usuario['usuario_id'];
            $_SESSION['logado'] = true;
            $_SESSION['erro'] = '';
            header('Location: home.php');
        }else{
            $_SESSION['erro'] = 'Erro ao cadastrar o usuário';
            header('Location: cadastro.php');
        }
    }else{
        $_SESSION['erro'] = 'Erro ao cadastrar o usuário';
        header('Location: cadastro.php');
    }
}else{
    $_SESSION['erro'] = 'Cadastro de usuário inválido';
    header('Location: cadastro.php');
}

?>