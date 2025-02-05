<?php
# Nome do arquivo: usuario/list.php
# Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");

?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/form.css">

<div class="container">
    <form id="form" method="POST"
        action="<?= BASEURL ?>/controller/LoginController.php?action=saveCadastro">
        <h4 class="text-center">CADASTRO</h4>
        <div class="form">
            <div class="form-left">
                <div class="form-group">
                    <label for="txtNome">Nome:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome"
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="numberCpf">Cpf:</label>
                    <input class="form-control" type="number" id="numberCpf" name="cpf"
                        maxlength="20" placeholder="Informe o Cpf"
                        value="<?php echo isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''; ?>" />
                </div>

                <div class="form-group">
                    <label for="numberRg">Rg:</label>
                    <input class="form-control" type="number" id="numberRg" name="rg"
                        maxlength="45" placeholder="Informe o Rg"
                        value="<?php echo isset($dados["usuario"]) ? $dados["usuario"]->getRg() : ''; ?>" />
                </div>

                <div class="form-group">
                    <label for="numberTel_fixo">Telefone Fixo:</label>
                    <input class="form-control" type="number" id="numbertelcelular" name="telfixo"
                        maxlength="20" placeholder="Informe o telefone fixo"
                        value="<?php echo isset($dados["usuario"]) ? $dados["usuario"]->getTelFixo() : ''; ?>" />
                </div>

                <div class="form-group">
                    <label for="numberCpf">Telefone Celular:</label>
                    <input class="form-control" type="number" id="numbertelcelular" name="telcelular"
                        maxlength="20" placeholder="Informe o celular"
                        value="<?php echo isset($dados["usuario"]) ? $dados["usuario"]->getTelCelular() : ''; ?>" />
                </div>
            </div>

            <div class="form-right">
                <div class="form-group">
                    <label for="txtEmail">E-mail:</label>
                    <input class="form-control" type="text" id="txtEmail" name="email"
                        maxlength="70" placeholder="Informe o e-mail"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>" />
                </div>

                <!-- Definindo tipo como Cliente (campo oculto) -->
                <input type="hidden" name="tipo" value="Cliente">

                <div class="form-group">
                    <label for="selectSituacao">Situação:</label>
                    <select name="situacao" id="selectSituacao" class="form-control">
                        <option value="">Selecione a situação</option>
                        <?php foreach ($dados["situacoes"] as $sit): ?>
                            <option value="<?= $sit ?>"
                                <?php if (isset($dados["usuario"]) && $dados["usuario"]->getSituacao() == $sit) echo "selected"; ?>>
                                <?= $sit ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="txtSenha">Senha:</label>
                    <input class="form-control" type="password" id="txtPassword" name="senha"
                        maxlength="15" placeholder="Informe a senha" />
                </div>

                <div class="form-group">
                    <label for="txtConfSenha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtConfSenha" name="conf_senha"
                        maxlength="15" placeholder="Confirme a senha" />
                </div>
            </div>
        </div>

        <div class="btns">
            <button type="submit" class="btn btn-success botao-alinhar-cadastro">CADASTRAR</button>
            <a class="btn btn-secondary" href="<?= LOGIN_PAGE ?>">Voltar</a>
            <button type="reset" class="btn btn-danger">Limpar</button>
        </div>
    </form>

    <div class="col-12">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>
