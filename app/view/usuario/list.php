<?php
#Nome do arquivo: usuario/list.php

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">



<div class="container">
    <h3 class="text-center">Usuários</h3>

    <div class="row">
        <div class="col-3">
            <a class="btn btn-success"
                href="<?= BASEURL ?>/controller/UsuarioController.php?action=create">
                Inserir</a>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabUsuarios" class=''>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>Tipo</th>
                        <th>Situação</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['lista'] as $usu): ?>
                        <tr>
                            <td><?php echo $usu->getId(); ?></td>
                            <td><?= $usu->getNome(); ?></td>
                            <td><?= $usu->getEmail(); ?></td>
                            <td><?= $usu->getTipo(); ?></td>
                            <td><?= $usu->getSituacao(); ?></td>
                            <td><a class="btn btn-primary"
                                    href="<?= BASEURL ?>/controller/UsuarioController.php?action=edit&id=<?= $usu->getId() ?>">
                                    Alterar</a>
                            </td>
                            <td><a class="btn btn-danger"
                                    onclick="return confirm('Confirma a exclusão do usuário?');"
                                    href="<?= BASEURL ?>/controller/UsuarioController.php?action=delete&id=<?= $usu->getId() ?>">
                                    Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php
    require_once(__DIR__ . "/../include/footer.php");
    ?>