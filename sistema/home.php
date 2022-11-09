<?php
require_once('../midas_conex.classe.php');

$midasSistema = new MyMidas;

$logado = $midasSistema->logado();

if($logado){

}else{
    $_SESSION['logado'] = false;
    header('Location: '.$this->retornaInicio().'midas/sistema/login.php');
}
?>