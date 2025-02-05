<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/menu.css">

<nav class="navbar fixed-top navbar-expand-lg">
    <a class="navbar-brand" href="<?= HOME_PAGE ?>">
        <img src="<?= BASEURL ?>/assets/logo.png" alt="Logo">
        MARTINBUS
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" 
            aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= HOME_PAGE ?>">Home</a>
            </li>

            <?php if($_SESSION[SESSAO_USUARIO_TIPO] == Tipo::MANTENEDOR || $_SESSION[SESSAO_USUARIO_TIPO] == Tipo::MOTORISTA): ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> Cadastros </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <?php if($_SESSION[SESSAO_USUARIO_TIPO] == Tipo::MANTENEDOR): ?>
                            <a class="dropdown-item" 
                                href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários</a>
                        <?php endif; ?>
                        
                        <?php if($_SESSION[SESSAO_USUARIO_TIPO] == Tipo::MOTORISTA): ?>
                            <a class="dropdown-item" 
                                href="<?= BASEURL . '/controller/OnibusController.php?action=list' ?>">Veículos</a>
                            <a class="dropdown-item" 
                                href="<?= BASEURL . '/controller/ViagensController.php?action=list' ?>">Viagens</a>
                        <?php endif; ?>
                            
                    </div>
                </li>
            
            <?php endif; ?>

            <?php if(isset($_SESSION[SESSAO_USUARIO_TIPO])): ?>
                <li class="nav-item">
                    <?php if($_SESSION[SESSAO_USUARIO_TIPO] == Tipo::MOTORISTA): ?>
                        <a class="nav-link" href="<?= BASEURL . '/controller/PassagemController.php?action=listarPedidosMotorista' ?>">Minhas Passagens</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= BASEURL . '/controller/PassagemController.php?action=listarPedidosUsuario' ?>">Minhas Passagens</a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="<?= LOGOUT_PAGE ?>">Sair</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <span class="nav-link" style="color: white; font-weight: bold;"><?= $nome ?></span>
            </li>
        </ul>
    </div>
</nav>
