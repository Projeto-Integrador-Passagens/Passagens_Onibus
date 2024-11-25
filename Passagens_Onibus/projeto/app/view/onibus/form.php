<?php
# Nome do arquivo: onibus/list.php
# Objetivo: interface para listagem dos ônibus do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/form.css">

<div class="container">
    <h3 class="text-center">
        <?php if ($dados['id'] == 0) echo "Inserir";
        else echo "Alterar"; ?>
        Veiculo
    </h3>


    <form id="form" method="POST"
        action="<?= BASEURL ?>/controller/OnibusController.php?action=save">

        <div class="form-group">
            <label for="txtModelo">Modelo:</label>
            <input class="form-control" type="text" id="txtModelo" name="modelo"
                maxlength="70" placeholder="Informe o modelo"
                value="<?php echo (isset($dados["onibus"]) ? $dados["onibus"]->getModelo() : ''); ?>" />
        </div>

        <div class="form-group">
            <label for="txtMarca">Marca:</label>
            <input class="form-control" type="text" id="txtMarca" name="marca"
                maxlength="70" placeholder="Informe a marca"
                value="<?php echo (isset($dados["onibus"]) ? $dados["onibus"]->getMarca() : ''); ?>" />
        </div>

        <div class="form-group">
            <label for="numberTotalAssentos">Total de Assentos:</label>
            <input class="form-control" type="number" id="numberTotalAssentos" name="total_assentos"
                placeholder="Informe o total de assentos"
                value="<?php echo (isset($dados["onibus"]) ? $dados["onibus"]->getTotalAssentos() : ''); ?>" />
        </div>

        <input type="hidden" id="hddId" name="id"
            value="<?= $dados['id']; ?>" />

        <div class="btns">
            <button type="submit" class="btn btn-success">Gravar</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
            <a class="btn btn-secondary"
                href="<?= BASEURL ?>/controller/OnibusController.php?action=list">Voltar</a>
        </div>
    </form>
    <div class="col-6">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>
</div>



<?php
require_once(__DIR__ . "/../include/footer.php");
?>