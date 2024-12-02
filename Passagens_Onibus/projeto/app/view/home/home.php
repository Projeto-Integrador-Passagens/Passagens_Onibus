<?php
# Nome do arquivo: home.php
# Objetivo: Página inicial para listar as viagens disponíveis

require_once(__DIR__ . "/../include/header.php");  // Inclui o cabeçalho
require_once(__DIR__ . "/../include/menu.php");    // Inclui o menu
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/form.css">

<div class="container mt-5">
    <h3 class="text-center">Viagens Disponíveis</h3>
    
    <!-- Filtro de Viagens (Opcional) -->

    <form id="form" method="POST"
        action="<?= BASEURL ?>/controller/HomeController.php?action=save">
    <div class="row">
        <div class="col-3">
            <label for="origem">Origem:</label>
            <select id="origem" class="form-control">
                <option value="">Selecione...</option>
                <?php foreach($dados['listaCidadeOrigem'] as $cidade): ?>
                    <option value="<?= $cidade['cidade_origem'] ?>"><?= $cidade['cidade_origem'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-3">
            <label for="destino">Destino:</label>
            <select id="destino" class="form-control">
                <option value="<?php echo (isset($dados["viagem"]) ? $dados["viagem"]->getCidadeDestino() : ''); ?>">Selecione...</option>
                <!-- Aqui seria interessante preencher dinamicamente com cidades -->
            </select>
        </div>
        <div class="col-3">
            <label for="data">Data:</label>
            <input type="date" id="data" class="form-control">
        </div>
        <div class="col-3">
            <button id="filtrar" class="btn btn-primary mt-4">Filtrar</button>
        </div>
    </div>
    </form>
    <div class="row" style="margin-top: 20px;">
        <div class="col-12">
            <!-- Mensagem de Status (Caso haja algum feedback do sistema) -->
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <!-- Exibindo as viagens disponíveis -->
            <?php if (isset($dados['lista']) && is_array($dados['lista']) && count($dados['lista']) > 0): ?>
                <table id="tabViagens" class="table">
                    <thead>
                        <tr>
                            <th>Veículo</th>
                            <th>Data e Horário</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Preço</th>
                            <th>Passagens Disponíveis</th>
                            <th>Situação</th>
                            <th>Comprar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados['lista'] as $viagem): ?>
                            <tr>
                                <td><?= $viagem->getOnibus()->getId(); ?></td>
                                <td><?= $viagem->getDataHorarioFormatado(); ?></td>
                                <td><?= $viagem->getCidadeOrigem(); ?></td>
                                <td><?= $viagem->getCidadeDestino(); ?></td>
                                <td><?= $viagem->getPrecoFormato(); ?></td>
                                <td><?= $viagem->getTotalPassagens(); ?></td>
                                <td><?= $viagem->getSituacao(); ?></td>
                                <td><a class="btn btn-success" href="<?= BASEURL ?>/controller/ViagensController.php?action=list<?= $viagem->getId() ?>">Comprar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Não há viagens disponíveis no momento.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");  // Inclui o rodapé
?>
