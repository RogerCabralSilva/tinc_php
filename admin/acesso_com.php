<?php
    session_name('chuleta');
    session_start(); // Inicia a sessão

    // Verificar se o usuário está logado
    if(!isset($_SESSION['login_usuario'])){
        // Se não estiver logado, redireciona para a página de login
        header('Location: login.php');
        exit;
    }

    // Verificar se o nome da sessão corresponde ao esperado
    // No seu caso, você pode simplesmente verificar se o nome da sessão está correto
    if (session_name() !== 'chuleta') {
        session_destroy();
        header('Location: login.php');
        exit;
    }
?>
