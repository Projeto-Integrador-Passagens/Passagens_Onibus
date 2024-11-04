<?php
# Nome do arquivo: login/login.php
# Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");

?>

<style>
    /* Fundo da página com gradiente */
    body {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    /* Caixa de login centralizada */
    .login-container {
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 100%;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    /* Logo */
    .login-container img {
        max-width: 150px; /* Ajuste para o tamanho desejado */
        width: 100%; /* Faz a imagem ocupar a largura total do contêiner */
        height: auto; /* Mantém a proporção da imagem */
        margin-bottom: 20px;
    }

    /* Alert Container */
    .alert {
        width: 100%; /* Ocupa toda a largura da caixa de login */
        padding: 25px; /* Adiciona padding para espaçamento interno */
        margin: 20px 0; /* Margem em cima e embaixo */
    }

    /* Inputs e botões */
    .login-container .form-group input {
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }

    .login-container button {
        width: 100%;
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        background-color: transparent;
        border: 2px solid transparent;
        color: white;
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        transition: background 0.3s, border-color 0.3s;
    }

    .login-container button:hover {
        border-color: #0072ff;
    }

    /* Link de registro */
    .login-container a {
        display: block;
        margin-top: 15px;
        color: #0072ff;
    }
</style>

<div class="container">
    <div class="login-container">
        <!-- Logo -->
        <img src="<?= BASEURL ?>/app/view/img/logo.jpg" alt="Logo">

        <div class="alert alert-info">
            <h4>Fazer Login</h4>
            <br>

            <!-- Formulário de login -->
            <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                <div class="form-group">
                    <label for="txtEmail">Email:</label>
                    <input type="text" class="form-control" name="email" id="txtEmail"
                        maxlength="70" placeholder="Informe o email"
                        value="<?php echo isset($dados['email']) ? htmlspecialchars($dados['email']) : '' ?>" required />        
                </div>

                <div class="form-group">
                    <label for="txtSenha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="txtSenha"
                        maxlength="15" placeholder="Informe a senha"
                        value="<?php echo isset($dados['senha']) ? htmlspecialchars($dados['senha']) : '' ?>" required />        
                </div>

                <button type="submit" class="btn btn-success">Logar</button>
            </form>

            <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=create">Não possui conta? Clique aqui</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
