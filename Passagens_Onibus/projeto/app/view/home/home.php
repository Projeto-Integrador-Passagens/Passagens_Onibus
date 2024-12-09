<?php
# Nome do arquivo: viagens/list.php
# Objetivo: interface para listagem das viagens do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">

<div class="container mt-5">
    <h3 class="text-center">Viagens Disponíveis
    </h3>

    <div class="row" style="margin-top: 50px;">
        <div class="col-12">
            <form id="form" method="GET"
                action="<?= BASEURL ?>/controller/HomeController.php">

                <input type="hidden" name="action" value="home" />

                <div class="row">
                    <div class="col-3">
                        <label for="origem">Origem:</label>
                        <select id="origem" class="form-control" name="origem">
                            <option value="">Selecione...</option>
                            <?php foreach ($dados['listaCidadeOrigem'] as $cidade): ?>
                                <option value="<?= $cidade['cidade_origem'] ?>"><?= $cidade['cidade_origem'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="origem">Destino:</label>
                        <select id="origem" class="form-control" name="origem">
                            <option value="">Selecione...</option>
                            <?php foreach ($dados['listaCidadeDestino'] as $cidade): ?>
                                <option value="<?= $cidade['cidade_destino'] ?>"><?= $cidade['cidade_destino'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="data">Data:</label>
                        <input type="date" id="data" name="data" class="form-control">
                    </div>
                    <div class="col-3">
                        <button id="filtrar" class="btn btn-primary align-middle">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    

    <div class="row" style="margin-top: 50px;">
        <div class="col-12">
            <table id="tabViagens" class=''>
                <thead>
                    <tr>
                        <th>Veiculo</th>
                        <th>Data e Horário</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Preço</th>
                        <th>Passagens</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['listaViagensDisp'] as $viagem): ?>
                        <tr>
                            <td><?= $viagem->getOnibus()->getInfo(); ?></td>
                            <td><?= $viagem->getDataHorarioFormatado(); ?></td>
                            <td><?= $viagem->getCidadeOrigem(); ?></td>
                            <td><?= $viagem->getCidadeDestino(); ?></td>
                            <td><?= $viagem->getPrecoFormato(); ?></td>
                            <td><?= $viagem->getTotalPassagens(); ?></td>
                            <td><a class="btn btn-success" href="<?= BASEURL ?>/controller/VendasController.php?action=vender&id_viagem=<?= $viagem->getId() ?>">Comprar</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    require_once(__DIR__ . "/../include/footer.php");
    ?>