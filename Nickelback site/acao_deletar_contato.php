<?php
//inicia sessão
session_start();

//arquivo com scripts para acesso ao banco
require 'bd.php';
    
//verifica se o administrador está logado
if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['nome']) && !empty($_SESSION['nome']) &&  isset($_SESSION['tipo']) && !empty($_SESSION['tipo']) && $_SESSION['tipo'] =="?????"){
    
    //delete da tabela contatos
    $sql = "DELETE FROM ADM_CONTATOS";    
    
    $resultado = mysqli_query($_LG['link'], $sql);
    
    //verifica se a query funcionou corretamente
    if($resultado){
        header("Location: administrador.php?retorno=ok");
    } else {
        criaCookie("bd");
        header("Location: administrador.php?retorno=erro");
    }
} else {
    header("Location: lpfan.php?retorno=erro");
}
