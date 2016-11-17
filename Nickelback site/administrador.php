<?php
//inicia sessão
session_start();

//verifica se o administrador está logado
if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['nome']) && !empty($_SESSION['nome']) &&  isset($_SESSION['tipo']) && !empty($_SESSION['tipo']) && $_SESSION['tipo'] =="1"){
    
    //arquivo com scripts para acesso ao banco
    require 'bd.php';
    
    //select de todos os contatos no banco
    $sql = "SELECT 
                ID, 
                NOME,
                DATA,
                EMAIL,
                MENSAGEM
            FROM
                ADM_CONTATOS
                
    ";
    
    $resultado = mysqli_query($_LG['link'], $sql);
    
?>
<html>

    <head>
        <title>Admin</title>
        <link rel='stylesheet' type='text/css' href='estilo.css'>  
        <meta charset='utf-8'>
    </head>

    <body>
        <?php include('menu.php'); ?>   
        <section id='administrador'>
            <h1 class='titulo'>Administrador</h1>
            <section>
                <input type='button' name='apagar' value='Apagar Tudo' onclick='javascript:location.href="acao_deletar_contato.php"'>
                <table>
                
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Mensagem (Clique para ver)</th> 
                    </tr>
                    
                    <?php 
                    if(mysqli_num_rows($resultado) > 0): 
                        while($linha = mysqli_fetch_assoc($resultado)):
                    ?>
                    
                    <tr>
                        <td><?php echo $linha["nome"]; ?></td>
                        <td><?php echo $linha["email"]; ?></td>
                        <td class='msg'>
                            <?php echo $linha["mensagem"]; ?>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                    <tr><td colspan=3>Nenhum Contato Encontrado</td></tr>
                    <?php endif; ?>
                </table>
            </section>
        </section>

        <?php include('footer.php'); ?>
    </body>
</html>
<?php
} else {
    header("Location: lpfan.php?retorno=erro");
}
?>
