<?php

//inicia sessão
session_start();

//arquivo com scripts para acesso ao banco
require 'bd.php';

//verifica se o método de requisição foi post
if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $login = addslashes($_POST['login']);
    $senha = addslashes($_POST['senha']);
    
    function criaCookie($m){
        //cria um cookie com o array dos dados recebidos via post e o erro identificado
        $ck = array(
            "login" => $login,
            "erro" => $m
        );  
        setcookie('_logar', $ck);
    }
    
    if($login == null || $senha == null){
        //não recebeu variáveis necessárias
        criaCookie("campo_null");
        header("Location: lpfan.php?retorno=errologin");
    }
    
    //query de consulta ao banco
    $sql = "SELECT
                NOME,  
                CONTA_ADMINISTRADORA
            FROM
                LP_USUARIOS
            WHERE
                NOME_USUARIO = '$login'
            AND
                SENHA = '$senha'
            ";

    $resultado = mysqli_query($_LG['link'], $sql);
    
    $dados = mysqli_fetch_assoc($resultado);
        
    //verifica se o select retornou resultado
    if(mysqli_num_rows($resultado) > 0){
        $_SESSION['login'] = $login;
        $_SESSION['tipo'] = $dados['CONTA_ADMINISTRADORA'];
        $_SESSION['nome'] = $dados['NOME'];
        
        if(!empty($dados['CONTA_ADMINISTRADORA'])){
            header("Location: administrador.php");
        } else {
            header("Location: lpfan.php");             
        }
        
    } else {
        //usuário ou senha não conferem
        criaCookie("sem_acesso");
        unset ($_SESSION['login']);
        unset ($_SESSION['tipo']);
        unset ($_SESSION['nome']);
        header("Location: lpfan.php?retorno=errologin");
    }
}