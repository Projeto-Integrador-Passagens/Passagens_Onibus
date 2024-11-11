<?php
# Nome do arquivo: viagens/list.php
# Objetivo: interface para listagem das viagens do sistema

require_once(__DIR__ . "/../include/header.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/form.css">

<div class="container">

    <form id="form" method="POST"
        action="<?= BASEURL ?>/controller/ViagensController.php?action=save">

        <h3 class="text-center">
            <?php if ($dados['id'] == 0) echo "Inserir";
            else echo "Alterar"; ?>
            Viagem
        </h3>
        <div class="form">
            <div class="form-left">
                <div class="form-group">
                    <label for="txtDataHorario">Data e Horário:</label>
                    <input class="form-control" type="datetime-local" id="txtDataHorario" name="data_horario"
                        placeholder="Informe a data e horário da viagem"
                        value="<?php echo (isset($dados["viagem"]) ? $dados["viagem"]->getDataHorario() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtCidadeOrigem">Cidade de Origem:</label>
                    <input class="form-control" type="text" id="txtCidadeOrigem" name="cidade_origem"
                        maxlength="70" placeholder="Informe a cidade de origem"
                        value="<?php echo (isset($dados["viagem"]) ? $dados["viagem"]->getCidadeOrigem() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtCidadeDestino">Cidade de Destino:</label>
                    <input class="form-control" type="text" id="txtCidadeDestino" name="cidade_destino"
                        maxlength="70" placeholder="Informe a cidade de destino"
                        value="<?php echo (isset($dados["viagem"]) ? $dados["viagem"]->getCidadeDestino() : ''); ?>" />
                </div>
            </div>

            <div class="form-right">

                <div class="form-group">
                    <label for="txtPreco">Preço:</label>
                    <input class="form-control" type="number" step="0.01" id="txtPreco" name="preco"
                        placeholder="Informe o preço da passagem"
                        value="<?php echo (isset($dados["viagem"]) ? $dados["viagem"]->getPreco() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtTotalPassagens">Total de Passagens:</label>
                    <input class="form-control" type="number" id="txtTotalPassagens" name="total_passagens"
                        placeholder="Informe o total de passagens"
                        value="<?php echo (isset($dados["viagem"]) ? $dados["viagem"]->getTotalPassagens() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtSituacao">Situação:</label>
                    <select class="form-control" id="txtSituacao" name="situacao">
                        <option value="disponível" <?php echo (isset($dados["viagem"]) && $dados["viagem"]->getSituacao() == "disponível" ? 'selected' : ''); ?>>Disponível</option>
                        <option value="indisponível" <?php echo (isset($dados["viagem"]) && $dados["viagem"]->getSituacao() == "indisponível" ? 'selected' : ''); ?>>Indisponível</option>
                    </select>
                </div>
            </div>

            <input type="hidden" id="hddId" name="id"
                value="<?= $dados['id']; ?>" />

        </div>

        <div class="btns">
            <button type="submit" class="btn btn-success">Gravar</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
            <a class="btn btn-secondary"
                href="<?= BASEURL ?>/controller/ViagensController.php?action=list">Voltar</a>
        </div>
    </form>
    <div class="col-6">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>
</div>



<?php
require_once(__DIR__ . "/../include/footer.php");
?>