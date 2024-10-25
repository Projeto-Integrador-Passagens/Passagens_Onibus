<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
?>

<h3 class="text-center">Veiculo</h3>

<div class="container">
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
        <table id="tabOnibus" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Total Assentos</th>
                    <th>Usuários ID</th>
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
            <td><?= $onibus->getUsuariosId(); ?></td>
            <td><a class="btn btn-primary" href="<?= BASEURL ?>/controller/OnibusController.php?action=edit&id=<?= $onibus->getId() ?>">Alterar</a></td>
            <td><a class="btn btn-danger" onclick="return confirm('Confirma a exclusão?');" href="<?= BASEURL ?>/controller/OnibusController.php?action=delete&id=<?= $onibus->getId() ?>">Excluir</a></td>
        </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>
</div>
