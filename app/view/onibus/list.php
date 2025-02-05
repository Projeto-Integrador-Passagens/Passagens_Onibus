<?php
#Nome do arquivo: onibus/list.php
#Objetivo: interface para listagem dos ônibus do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">

<div class="container mt-5">
    <h3 class="text-center">Veiculo</h3>
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success"
                href="<?= BASEURL ?>/controller/OnibusController.php?action=create">
                Inserir</a>
        </div>
        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabOnibus" class=''>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Total Assentos</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['lista'] as $onibus): ?>
                        <tr>
                            <td><?php echo $onibus->getId(); ?></td>
                            <td><?= $onibus->getModelo(); ?></td>
                            <td><?= $onibus->getMarca(); ?></td>
                            <td><?= $onibus->getTotalAssentos(); ?></td>
                            <td><a class="btn btn-primary" href="<?= BASEURL ?>/controller/OnibusController.php?action=edit&id=<?= $onibus->getId() ?>">Alterar</a></td>
                            <td><a class="btn btn-danger" onclick="return confirm('Confirma a exclusão?');" href="<?= BASEURL ?>/controller/OnibusController.php?action=delete&id=<?= $onibus->getId() ?>">Excluir</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    require_once(__DIR__ . "/../include/footer.php");
    ?>