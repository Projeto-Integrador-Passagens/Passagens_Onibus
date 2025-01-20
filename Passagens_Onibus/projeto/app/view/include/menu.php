<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

include_once (__DIR__  . "../../estilizacao/menu.css");

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
?>

<style>
    /* Estilo geral da navbar */
    .navbar {
        background: linear-gradient(90deg, #007BFF, #0056b3); /* Gradiente azul */
        padding: 10px 20px; /* Menor padding para reduzir o menu */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
        z-index: 10;
    }

    /* Estilo do link da navbar */
    .navbar .nav-link {
        color: white !important;
        font-weight: 500;
        font-size: 14px; /* Diminuído o tamanho da fonte */
        padding: 6px 12px; /* Diminuído o padding */
        transition: all 0.3s ease;
    }

    /* Hover nos links da navbar */
    .navbar .nav-link:hover {
        color: #87CEFA !important; /* Azul-claro */
        transform: scale(1.05); /* Aumentar um pouco o tamanho */
    }

    /* Estilo do menu dropdown */
    .navbar .dropdown-menu {
        background: linear-gradient(90deg, #0056b3, #007BFF);
        border: none;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .navbar .dropdown-menu .dropdown-item {
        color: white !important;
        font-size: 14px;
        padding: 8px 15px; /* Menor padding */
        transition: all 0.3s ease;
    }

    /* Hover nas opções do menu dropdown */
    .navbar .dropdown-menu .dropdown-item:hover {
        background: #87CEFA; /* Azul-claro */
        color: #0056b3 !important;
        font-weight: bold;
    }

    /* Estilo do nome do usuário na navbar */
    .navbar .navbar-brand {
        display: flex;
        align-items: center;
        color: white !important;
        font-weight: bold;
        font-size: 22px; /* Diminuído o tamanho da fonte */
        background-image: linear-gradient(to right, #003366, #0056b3);
        -webkit-background-clip: text;
        color: transparent;
    }

    /* Logo da navbar */
    .navbar .navbar-brand img {
        height: 40px; /* Ajuste o tamanho da logo */
        margin-right: 10px; /* Menor espaçamento entre a logo e o texto */
    }

    /* Responsividade - ajustando para telas pequenas */
    @media (max-width: 768px) {
        .navbar .navbar-brand {
            font-size: 20px; /* Diminuído o tamanho da fonte */
        }

        .navbar .navbar-nav {
            text-align: center;
        }

        .navbar .nav-link {
            font-size: 14px; /* Tamanho menor da fonte */
            padding: 8px;
        }
    }
</style>

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