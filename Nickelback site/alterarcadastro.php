<?php
//inicia sessão
session_start();
$msgForm = "";

//verifica se o usuário está logado
if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['nome']) && !empty($_SESSION['nome']) &&  isset($_SESSION['tipo']) && !empty($_SESSION['tipo'])){
    
    if(isset($_GET["retorno"]) && $_GET["retorno"] == "erro"){
        $dados = $_COOKIE["_edi_usuario"];
        $dados = json_decode($dados);
        $nome = $dados->nome;
        $username = $dados->username;
        $email = $dados->email;
        switch($dados->erro){
            case 'email':
                $msgForm = "E-mail inválido.";
                break;
            case 'campo_null':
                $msgForm = "Todos os campos devem ser preenchidos.";
                break;
            case 'senha_atual':
                $msgForm = "A senha atual informada não confere.";
                break;
            case 'senha':
                $msgForm = "A nova senha não confere com a confirmação.";
                break;
            case 'bd':
                $msgForm = "Ocorreu um erro interno no processamento.";
                break;
            default:
                $msgForm = "Ocorreu um erro interno.";
        }
    } else {
        
        //arquivo com scripts para acesso ao banco
        require 'bd.php';
        
        //select do usuário com username $_SESSION['username'] no banco
        $sql = "SELECT
                    NOME,  
                    NOME_USUARIO,
                    EMAIL,
                    SENHA
                FROM
                    LP_USUARIOS
                WHERE
                    NOME_USUARIO = '$username'           
                ";
        
        $resultado = mysqli_query($sql, $_LG['link']);
        if(mysqli_num_rows($resultado) <= 0){
            header("Location: erro.php");
        }
        $dados = mysqli_fetch_array($resultado);
        $nome = $dados['??nome??'];
        $username = $dados['??usename??'];
        $email = $dados['??email??'];
    }
    
?>
<html>

    <head>
        <title>Alterar Cadastro</title>
        <link rel='stylesheet' type='text/css' href='estilo.css'>  
        <meta charset='utf-8'>
    </head>

    <body>
        <?php include('menu.php'); ?>   
        <section id='alteracao'>
            <h1 class='titulo'>ALTERAR CADASTRO</h1>
            <form method='post' action='acao_editar_usuario.php'>    
                <label for='nome'>Novo Nome:</label><input type='text' name='nome' id='nome' value="<?php echo $nome; ?>">
                <label for='username'>Novo Usuário: </label><input type='text' name='username' id='username' value="<?php echo $username; ?>">
                <label for='email'>Novo E-mail:</label><input type='email' name='email' id='email' value="<?php echo $email; ?>">
                <label for='senha'>Nova Senha:</label><input type='password' name='senha' id='senha'>
                <label for='confirmsenha'>Confirme a senha:</label><input type='password' name='confirmsenha' id='confirmsenha'>
                <label for='confirmsenha'>Senha atual:</label><input type='password' name='senhaatual' id='confirmsenha'>
                <input name='alterar' type='submit' value='Alterar'>
                <?php
                //verifica se a variável $msgForm foi alterada
                if ($msgForm != "")
                    echo "<span style='color:green;'>".$msgForm."</span>";
                ?> 
            </form>
        </section>

        <?php include('footer.php'); ?>
    </body>
</html>
