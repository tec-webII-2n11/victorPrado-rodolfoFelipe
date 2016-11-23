<?php

//arquivo com scripts para acesso ao banco
require 'bd.php';

//verifica se o método de requisição foi post
if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $nome = addslashes($_POST["nome"]);
    $email = addslashes($_POST["email"]);
    $mensagem = addslashes($_POST["mensagem"]);
    
    function criaCookie($m){
        //cria um cookie com o array dos dados recebidos via post e o erro identificado
        $ck = array(
            "nome" => addslashes($_POST["nome"]),
            "email" => addslashes($_POST["email"]),
            "mensagem" => addslashes($_POST["mensagem"]),
            "erro" => $m
        );  
        $json = json_encode($ck);
        setcookie('_contato', $json, time()+3600);
    }    
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //e-mail inválido
        criaCookie("email");
        header("Location: contato.php?retorno=erro");
    }
    
    if($nome == null || $email == null || $mensagem == null){
        //não recebeu variáveis necessárias
        criaCookie("campo_null");
        header("Location: contato.php?retorno=erro");
    }
    
    //insert no banco de dados
    $sql = "INSERT INTO
                ADM_CONTATOS
                (
                    NOME,
                    EMAIL,
                    MENSAGEM
                )
                VALUES
                (
                    '$nome',
                    '$email',
                    '$mensagem'
                )
           ";
    
    $resultado = mysqli_query($_LG['link'], $sql);

    //verifica se o insert funcionou corretamente
    if($resultado){
        setcookie("_contato");
        header("Location: contato.php?retorno=enviado");
    } else {
        criaCookie("bd");
        header("Location: contato.php?retorno=erro");
    }
    
} else {
    //direciona o usuário para uma página de erro.
    header("Location: erro.php");
}