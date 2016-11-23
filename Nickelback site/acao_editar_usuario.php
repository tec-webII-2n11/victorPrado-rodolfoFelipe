<?php
//inicia sessão
session_start();

//arquivo com scripts para acesso ao banco
require 'bd.php';

//verifica se o método de requisição foi post
if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    //verifica se o usuário está logado
    if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
        $nome = addslashes($_POST["nome"]);
        $username = addslashes($_POST["username"]);
        $email = addslashes($_POST["email"]);
        $senha = addslashes($_POST["senha"]);
        $confirmsenha = addslashes($_POST["confirmsenha"]);
        $senhaatual = addslashes($_POST["senhaatual"]);
        
        function criaCookie($m){
            //cria um cookie com o array dos dados recebidos via post e o erro identificado
            $ck = array(
                "nome" => addslashes($_POST["nome"]),
                "email" => addslashes($_POST["email"]),
                "username" => addslashes($_POST["username"]),
                "erro" => $m
            );  
            $json = json_encode($ck);
            setcookie('_edi_usuario', $json);
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            //e-mail inválido
            criaCookie("email");
            header("Location: alterarcadastro.php?retorno=erro");
        }
        
        if($nome == "" || $email == "" || $username == ""){
            //não recebeu variáveis necessárias
            criaCookie("campo_null");
            header("Location: alterarcadastro.php?retorno=erro");
        }
        
        if($senhaatual == ""){
            //não digitou senha atual
            criaCookie("senha_atual");
            header("Location: alterarcadastro.php?retorno=erro");
        }
        
        if($senha != ""){
            if($senha != $confirmsenha){
                //senha não confere com confirmação
                criaCookie("senha");
                header("Location: alterarcadastro.php?retorno=erro");
            } else {
                $senhaatual = $senha;
            }
        }
        
        //select que valida usuário usando $_SESSION['login'] e $senha
        $sql_validar = "";
        
        $resultado_validar = mysqli_query($_LG['link'], $sql_validar);
        
        if(mysql_num_rows($resultado_validar) > 0){
            //update na tabela usuários. Para senha usar $senhaatual
            $sql = "UPDATE 
                        LP_USUARIOS
                    SET
                        (
                            NOME = '$nome',  
                            NOME_USUARIO = '$username',
                            EMAIL = '$email',
                            SENHA = '$senha'
                        )
                    WHERE
                        NOME_USUARIO = '$username'
                    AND
                        SENHA = '$senha'
            ";    
            
            $resultado = mysqli_query($_LG['link'], $sql);
            
            //verifica se a query funcionou corretamente
            if($resultado){
                header("Location: alterarcadastro.php?retorno=enviado");
            } else {
                criaCookie("bd");
                header("Location: alterarcadastro.php?retorno=erro");
            }
        }
    } else {
        header("Location: lpfan.php?retorno=erro");
    }
    
    
} else {
    //direciona o usuário para uma página de erro.
    header("Location: erro.php");
}