<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    Usuário
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmUsuario" method="POST" 
                action="<?= BASEURL ?>/controller/UsuarioController.php?action=save" >
                <div class="form-group">
                    <label for="txtNome">Nome:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome" 
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                </div>
                
                <div class="form-group">
                    <label for="txtLogin">Login:</label>
                    <input class="form-control" type="text" id="txtLogin" name="login" 
                        maxlength="15" placeholder="Informe o login"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getLogin() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtSenha">Senha:</label>
                    <input class="form-control" type="password" id="txtPassword" name="senha" 
                        maxlength="15" placeholder="Informe a senha"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtConfSenha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtConfSenha" name="conf_senha" 
                        maxlength="15" placeholder="Informe a confirmação da senha"
                        value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : '';?>"/>
                </div>


                <div class="form-group">
                    <label for="numberCpf">Cpf:</label>
                    <input class="form-control" type="number" id="numberCpf" name="Cpf" 
                        maxlength="15" placeholder="Informe o Cpf"
                        value="<?php echo isset($dados['Cpf']) ? $dados['Cpf'] : '';?>"/>
                </div>


                <div class="form-group">
                    <label for="numberRg">Rg:</label>
                    <input class="form-control" type="number" id="numberRg" name="Rg" 
                        maxlength="15" placeholder="Informe o Rg"
                        value="<?php echo isset($dados['Rg']) ? $dados['Rg'] : '';?>"/>
                </div>


                <div class="form-group">
                    <label for="numberTel_fixo">Telefone Fixo:</label>
                    <input class="form-control" type="number" id="numbertelcelular" name="telfixo" 
                        maxlength="15" placeholder="Informe o telfixo"
                        value="<?php echo isset($dados['telfixo']) ? $dados['telfixo'] : '';?>"/>
                </div>

                <div class="form-group">
                    <label for="numberCpf">telefone celular:</label>
                    <input class="form-control" type="number" id="numbertelcelular" name="telcelular" 
                        maxlength="15" placeholder="Informe o telcelular"
                        value="<?php echo isset($dados['telcelular']) ? $dados['telcelular'] : '';?>"/>
                </div>

                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />

                <button type="submit" class="btn btn-success">Gravar</button>
                <button type="reset" class="btn btn-danger">Limpar</button>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
        <a class="btn btn-secondary" 
                href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>