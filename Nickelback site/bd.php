<?php

$_LG['servidor'] = 'localhost:3308';    // Servidor MySQL ns1.hostinger.com.br
$_LG['usuario'] = 'root';          // Usuário MySQL
$_LG['senha'] = '';                // Senha MySQL
$_LG['banco'] = 'tecweb2';            // Banco de dados MySQL


$_LG['link'] = mysqli_connect($_LG['servidor'], $_LG['usuario'], $_LG['senha'], $_LG['banco']) or die("MySQL: Não foi possível conectar-se ao servidor.");


