<?php 
// inicializa variáveis
$msgForm = "";
$nome = "";
$email = "";
$mensagem = "";

// verifica se existe retorno
if(isset($_GET["retorno"])){
    switch($_GET["retorno"]){
        case 'erro':
            //Se erro, verifica se existe cookie
            if(isset($_COOKIE["_contato"])){
                $dados = $_COOKIE["_contato"];
                $dados = json_decode($dados);
                $nome = $dados->nome;
                $email = $dados->email;
                $mensagem = $dados->mensagem;
                switch($dados->erro){
                    case 'email':
                        $msgForm = "E-mail inválido.";
                        break;
                    case 'campo_null':
                        $msgForm = "Todos os campos devem ser preenchidos.";
                        break;
                    case 'bd':
                        $msgForm = "Ocorreu um erro interno no processamento.";
                        break;
                    default:
                        $msgForm = "Ocorreu um erro interno.";
                }
            }
            else { //se houver erro, mas não houver cookie
                $msgForm = "Ocorreu um erro interno.";
            }
            break;
        case 'enviado':
            $msgForm = "Mensagem enviada!";
            break;
        default:
            //se houver retorno, mas o valor for diferente de erro ou enviado.
            $msgForm = "Ocorreu um erro interno.";
    }
}
?>

<!DOCTYPE html>
<html>

    <head>
        <title>LPBR</title>
        <link rel="stylesheet" type="text/css" href="estilo.css">  
        <meta charset="utf-8">
    </head>

    <body>
        <?php include('menu.php'); ?>
    <section id='contato'>

            <h1 class='titulo'>CONTATO</h1>

            <section class="contatos" id="cont1">
                <h2>Contatos do desenvolvedor:</h2>
                <hr>
                <p>Email: contato.nickelbackbr@gmail.com</p>
                <img src="images/Nickelback.jpg" alt="desenvolvedor" height="200" width="300">
                <p>Mande sua mensagem!</p>
            </section>

            <section class="contatos">
                <h2>Sugestões:</h2>
                <hr>
                <form  method='post' action='acao_receber_contato.php'>
                    <input type="text" name="nome" placeholder="Nome" value="<?php echo $nome; ?>" required> Seu Nome<br>
                    <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>" required> Seu E-mail<br>

                    <p id="escreva">Escreva aqui sua sugestão ou comentário:<p>
                    <textarea name="mensagem" rows="10" cols="50" placeholder="Insira sua sugestão." required><?php echo $mensagem; ?></textarea><br>

                    <input type="submit" value="Enviar" id='enviar'>

                        <?php
                        //verifica se a variável $msgForm foi alterada
                        if ($msgForm != "")
                            echo "<span style='color:green;'>".$msgForm."</span>";
                        ?> 
                </form>   
            </section>
    </section>
        <?php include('footer.php');?>

    </body>

</html>