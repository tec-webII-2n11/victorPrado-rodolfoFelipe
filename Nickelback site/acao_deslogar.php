<?php
//inicia sessão
session_start();

unset($_SESSION['login']);

session_destroy();

// Manda pra tela de login
header("Location: index.php?acao=saiu");