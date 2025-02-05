<?php
# Nome do arquivo: login/login.php
# Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/login.css">


<div class="container" style="height: 100vh;">
        <!-- Formulário de login -->
         <img src="<?= BASEURL ?>/assets/logo.png" alt="">
         
        <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
            <h4 class="text-center">Login</h4>

            <div class="form-group">
                <label for="txtEmail">Email:</label>
                <input type="text" class="form-control" name="email" id="txtEmail"
                    maxlength="70" placeholder="Informe o email"
                    value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" required
                    style="color:white;" />
            </div>

            <div class="form-group">
                <label for="txtSenha">Senha:</label>
                <input type="password" class="form-control" name="senha" id="txtSenha"
                    maxlength="15" placeholder="Informe a senha"
                    value="<?php echo isset($dados['senha']) ? htmlspecialchars($dados['senha']) : '' ?>" required
                    style="color:white;" />
            </div>

            <div class="btns">
                <button type="submit" class="btn-success btnLogin">Logar</button>
                <div class="cadastroBtn">
                    <span>Não possui conta? </span><a href="<?= BASEURL ?>/controller/LoginController.php?action=createCadastro">Clique aqui</a>
                </div>
            </div>
        </form>


        <?php include_once(__DIR__ . "/../include/msg.php") ?>


</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>