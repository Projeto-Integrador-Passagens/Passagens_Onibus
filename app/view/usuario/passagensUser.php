<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">



<div class="container">
    <h3 class="text-center">Passagens compradas</h3>

    <div class="row">

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabUsuarios" class=''>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cpf</th>
                        <th>Data Venda</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Comprovante Pix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['minhasCompras'] as $pass): ?>
                        <tr>
                            <td><?= $pass->getNome(); ?></td>
                            <td><?= $pass->getCpf(); ?></td>
                            <td><?= $pass->getDataVenda(); ?></td>
                            <td><?= $pass->getViagem()->getCidadeOrigem(); ?></td>
                            <td><?= $pass->getViagem()->getCidadeDestino(); ?></td>
                            <td>
                                <a
                                    href="/Passagens_Onibus/arquivos/compPix/<?= $pass->getCompPix() ?>" target="_blank">
                                    Comprovante Pix
                                </a>
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