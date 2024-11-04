<?php
# Nome do arquivo: viagens/list.php
# Objetivo: interface para listagem das viagens do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Viagens</h3>

<div class="container">
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
            <table id="tabViagens" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ônibus ID</th>
                        <th>Data e Horário</th>
                        <th>Cidade de Origem</th>
                        <th>Cidade de Destino</th>
                        <th>Preço</th>
                        <th>Total de Passagens</th>
                        <th>Situação</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['lista'] as $viagem): ?>
                        <tr>
                            <td><?php echo $viagem->getId(); ?></td>
                            <td><?= $viagem->getOnibusId(); ?></td>
                            <td><?= $viagem->getDataHorario(); ?></td>
                            <td><?= $viagem->getCidadeOrigem(); ?></td>
                            <td><?= $viagem->getCidadeDestino(); ?></td>
                            <td><?= $viagem->getPreco(); ?></td>
                            <td><?= $viagem->getTotalPassagens(); ?></td>
                            <td><?= $viagem->getSituacao(); ?></td>
                            <td><a class="btn btn-primary" href="<?= BASEURL ?>/controller/ViagensController.php?action=edit&id=<?= $viagem->getId() ?>">Alterar</a></td>
                            <td><a class="btn btn-danger" onclick="return confirm('Confirma a exclusão?');" href="<?= BASEURL ?>/controller/ViagensController.php?action=delete&id=<?= $viagem->getId() ?>">Excluir</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>
