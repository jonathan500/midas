<?php
session_start();

class MyMidas{
    function __construct()
    {
        $host = "localhost";
        $user = "root";
        $password = "";
        $base = 'midas';

        $conexao = new mysqli($host, $user, $password,$base);
        if($conexao){
            $GLOBALS['conexao'] = $conexao;
        }else{
            $GLOBALS['conexao'] = 'falha';
        }
    }

    //consultar
    function consultar($colunas, $tabela, $condicoes = ''){

        if(empty($condicoes)){
            $query  = 'SELECT '.$colunas.' FROM '.$tabela;
        }else{
            $query  = 'SELECT '.$colunas.' FROM '.$tabela.' WHERE '.$condicoes;
        }
         
        return $query;
    }

    //deletar 
    function deletar($tabela, $condicoes){
        $query  = 'DELETE FROM '.$tabela.' WHERE '.$condicoes; 
        return $query;
    }

    // atualizar
    function atualizar($tabela, $alteracoes, $condicoes){
        $query  = 'UPDATE '.$tabela.' SET '.$alteracoes.' WHERE '.$condicoes; 
        return $query;
    }

    function inserir($tabela,$colunas,$valores){
        $query = 'INSERT INTO '.$tabela.'('.$colunas.')'.' VALUES ('.$valores.')';
        return $query;
    }

    // executar
    function executar($query){
        if($GLOBALS['conexao'] == 'falha'){
            return false;
        }else{
            $resultado = mysqli_query($GLOBALS['conexao'],$query);
        }
        return $resultado;
    }
    
    function retornaInicio(){
        $caminho = "$_SERVER[REQUEST_URI]";
        $caminho = explode('/',$caminho);
        $inicio = '';
        foreach($caminho as $key=>$link){
            if(!empty($link) && $link != 'midas')
                $inicio .= '../';
        }
    
        return $inicio;
    }

    function logado(){
        if($_SESSION['logado'] != true || !isset($_SESSION['logado'])){
            $_SESSION['logado'] = false; 
           header('Location: '.$this->retornaInicio().'midas/sistema/login.php');
        }else{
            return true;
        }
    }
    
    function sair(){
        if($_SESSION['logado']){
            session_destroy();
            header('Location: ../sistema/login.php');
        }else{
            session_destroy();
            header('Location: ../sistema/login.php');
        }
    }

}
    
?>