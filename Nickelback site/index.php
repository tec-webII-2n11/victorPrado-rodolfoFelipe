<?php
//inicia sessão
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>NCKB</title>
        <link rel='stylesheet' type='text/css' href='estilo.css'>  
        <meta charset='utf-8'>
    </head>

    <body>
        <?php include('menu.php'); ?>    
        <section class='home'>
            <h1 class='titulo'>Home</h1>
            <article>
                <h2>Bem vindo ao Nickelback BR!</h2><hr>
                <p>Este site é dedicado à divulgação de conteúdo da banda Nickelback. Aqui vocÊ encontrará informações sobre os discos lançados, integrantes e todo tipo de curiosidades sobre a banda.</p>
                 <img src='images/Nickelback.jpg' alt="Foto da Banda" 
                      Height="350" width="600" >  
            </article>
            <aside id='loginbox'>
            <?php if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['nome']) && !empty($_SESSION['nome'])): ?>
                <h2>Olá, <?php echo $_SESSION['nome']; ?></h2>
                <a href="acao_deslogar.php">sair</a>
            <?php else: ?>
                <h2>Faça login ou cadastre-se</h2>
                <form method='post' action='acao_logar.php'>
                    <input name='login' id='login' type='text' placeholder="Seu usuário"><label for='login'>Usuário </label>
                    <input name='senha' id='senha' type='password' placeholder="Sua senha"><label for ='senha'>Senha </label>
                    <input name='entrar' type='submit' value='Entrar'>
                    <input type='button' value='Cadastrar'>
                </form>
            <?php endif; ?>
            </aside>
            <aside>
                <h2>Redes Sociais da Banda:</h2>
                <p>Facebook</p>
                <a href='https://pt-br.facebook.com/Nickelback/' target='_blank'><img src='images/logos/facebook.png'></a>
                <p>Instagram</p>
                <a href='https://www.instagram.com/nickelback/?hl=pt' target='_blank'><img src='images/logos/instagram.png'></a>
                <p>Site Oficial</p>
                <a href='http://www.nickelback.com' target='_blank'><img src='images/logos/Nickelbacklogo.png'></a>
            </aside>
        </section>

        <?php include('footer.php'); ?>


    </body>

</html>