<?php
# Nome do arquivo: login/login.php
# Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");
?>
<img src="">
<div class="container" style="height: 100vh;">
    <div class="row justify-content-center align-items-center" style="height: 100%;">
        <div class="col-6"> 
        <div class="alert alert-info fonte-branca" style="background: linear-gradient(to right, #09d8df, #054798);">
                <h4 class="text-center">Login</h4>
                <br>


 



                        <!-- Formulário de login -->
  <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                    <div class="form-group">
                        <label for="txtEmail">Email:</label>
                        <input type="text" class="form-control" name="email" id="txtEmail"
                            maxlength="70" placeholder="Informe o email"
                            value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
                    </div>

                <div class="form-group">
                    <label for="txtSenha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="txtSenha"
                        maxlength="15" placeholder="Informe a senha"
                        value="<?php echo isset($dados['senha']) ? htmlspecialchars($dados['senha']) : '' ?>" required />        
                </div>

                <button type="submit" class="btn btn-success botao-alinhar">Logar</button>
                </form>

                <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=create">Não possui conta? Clique aqui</a>
            </div>


        </div>

        <div class="col-6">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
