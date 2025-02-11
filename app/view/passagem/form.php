<?php
# Nome do arquivo: venda/form.php
# Objetivo: interface para realizar a venda de passagens

require_once(__DIR__ . "/../include/header.php");
if (isset($_SESSION[SESSAO_USUARIO_ID]))
    require_once(__DIR__ . "/../include/menu.php");
?>

<?php
if (isset($_GET['id'])) {
    $idViagem = $_GET['id'];
}
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/form.css">

<div class="container" style="margin-top: 150px;">

    <h3 class="text-center fonte-branca">
        Venda de Passagens
    </h3>

    <div class="row">
        <div class="col">
            <h4>Dados da viagem</h4>

            <div>
                <span style="font-weight: bold;">Origem:</span>
                <span><?= $dados["viagem"]->getCidadeOrigem() ?></span>
            </div>

            <div>
                <span style="font-weight: bold;">Destino:</span>
                <span><?= $dados["viagem"]->getCidadeDestino() ?></span>
            </div>

            <div>
                <span style="font-weight: bold;">Preço:</span>
                <span><?= $dados["viagem"]->getPrecoFormato() ?></span>
            </div>

        </div>

    </div>

    <form enctype="multipart/form-data" id="formVenda" method="POST" action="<?= BASEURL ?>/controller/PassagemController.php?action=salvarCompra&id=<?= $idViagem ?>">


        <!-- Dados dos passageiros -->

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

        <div class="QrCode text-center">
            <img src="<?= BASEURL ?>/assets/QrCodeMartinBus.png"
                alt="QR Code de pagamento"
                width="40%">
        </div>

        <div class="form-group">
            <label for="numberCpf">Comprovante do pix:</label>
            <input class="form-control" type="file" id="compPix" name="compPix"
                placeholder="Informe o comprovante do pix." />
        </div>

        <div class="btns">
            <button type="submit" class="btn btn-success">Confirmar</button>
            <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/HomeController.php?action=home">Voltar</a>
        </div>

    </form>

    <div class="col-12">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>