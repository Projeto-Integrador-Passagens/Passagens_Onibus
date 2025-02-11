<?php
# Nome do arquivo: viagens/list.php
# Objetivo: interface para listagem das viagens do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">

<div class="container">
    <h3 class="text-center">Viagens</h3>
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success"
                href="<?= BASEURL ?>/controller/ViagensController.php?action=create">
                Inserir</a>
        </div>
        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabViagens">
                <thead>
                    <tr class='text-center'>
                        <th class='text-center'>Data e Horário</th>
                        <th class='text-center'>Origem</th>
                        <th class='text-center'>Destino</th>
                        <th class='text-center'>Preço</th>
                        <th class='text-center'>Passagens disponíveis</th>
                        <th class='text-center'>Situação</th>
                        <th class='text-center'>Passageiros</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['lista'] as $viagem): ?>
                        <tr>
                            <td class='text-center'><?= $viagem->getDataHorarioFormatado(); ?></td>
                            <td class='text-center'><?= $viagem->getCidadeOrigem(); ?></td>
                            <td class='text-center'><?= $viagem->getCidadeDestino(); ?></td>
                            <td class='text-center'><?= $viagem->getPrecoFormato(); ?></td>
                            <td class='text-center'><?= $viagem->getTotalPassagens(); ?></td>
                            <td class='text-center'><?= $viagem->getSituacao(); ?></td>
                            <td class='text-center'><a href="<?= BASEURL ?>/controller/ViagensController.php?action=listPassageirosByUsuario&id=<?= $viagem->getId() ?>">Ver passageiros</a></td>

                            <?php
                                if($viagem->getSituacao()!== "FINALIZADA"):
                            ?>

                            <td><a class="btn btn-danger" onclick="return confirm('Confirma a finalização da viagem?');" href="<?= BASEURL ?>/controller/ViagensController.php?action=finalizar&id=<?= $viagem->getId() ?>">FINALIZAR</a></td>

                            <?php
                                endif;
                            ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    require_once(__DIR__ . "/../include/footer.php");
    ?>