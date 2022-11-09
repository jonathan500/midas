<?php
session_start();

require('../midas_conex.classe.php');

$midasSistema = new MyMidas;

$usuario = $midasSistema->consultar('*',
                        'midas_usuarios',
                        'usuario_email = \''.$_POST['username'].'\' 
                        AND usuario_senha = \''.$_POST['password'].'\'');
                        
$exec_usuario = $midasSistema->executar($usuario);

if(mysqli_num_rows($exec_usuario) == 1){
    $_SESSION['logado'] = true;
    $_SESSION['erro'] = '';
    $re_exec_usuario = mysqli_fetch_assoc($exec_usuario);
    $_SESSION['usuario_id'] =  $re_exec_usuario['usuario_id'];
    header('Location: home.php');
}else{
    $_SESSION['erro'] = 'Credenciais invalidas';
    header('Location: login.php');
}
?>