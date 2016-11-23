<?php

//arquivo com scripts para acesso ao banco
require 'bd.php';

//verifica se o método de requisição foi post
if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $nome = addslashes($_POST["nome"]);
    $username = addslashes($_POST["username"]);
    $email = addslashes($_POST["email"]);
    $senha = addslashes($_POST["senha"]);
    $confirmsenha = addslashes($_POST["confirmsenha"]);
    
    function criaCookie($m){
        //cria um cookie com o array dos dados recebidos via post e o erro identificado
        $ck = array(
            "nome" => addslashes($_POST["nome"]),
            "email" => addslashes($_POST["email"]),
            "username" => addslashes($_POST["username"]),
            "erro" => $m
        );  
        $json = json_encode($ck);
        setcookie('_cad_usuario', $json);
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //e-mail inválido
        criaCookie("email");
        header("Location: lpfan.php?retorno=errocadastro");
    }
    
    if($nome == "" || $email == "" || $username == "" || $senha == ""){
        //não recebeu variáveis necessárias
        criaCookie("campo_null");
        header("Location: lpfan.php?retorno=errocadastro");
    }
    
    if($senha != $confirmsenha){
        //senha não confere com confirmação
        criaCookie("senha");
        header("Location: lpfan.php?retorno=errocadastro");
    }
    
    //insert na tabela usuários
    $sql = "INSERT INTO
                LP_USUARIOS
                (                
                    NOME,  
                    NOME_USUARIO,
                    EMAIL,
                    SENHA
                )
                VALUES
                (
                    '$nome',
                    '$username',
                    '$email',
                    '$senha'
                )";
                
                    
    
    $resultado = mysqli_query($_LG['link'], $sql);
    
    //verifica se a query funcionou corretamente
    if($resultado){
        header("Location: lpfan.php?retorno=enviado");
    } else {
        criaCookie("bd");
        header("Location: lpfan.php?retorno=errocadastro");
    }
    
} else {
    //direciona o usuário para uma página de erro.
    header("Location: erro.php");
}