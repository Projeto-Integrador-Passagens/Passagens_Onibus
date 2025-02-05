<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">

<div class="container">
    <h3 class="text-center">Passagens das Minhas Viagens</h3>

    <div class="row">
        <div class="col-12">
            <?php if (isset($passagens) && is_array($passagens) && count($passagens) > 0): ?>
                <table id="tabPassagensMotorista" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Passageiro</th>
                            <th>CPF</th>
                            <th>Viagem</th>
                            <th>Data da Compra</th>
                            <th>Valor</th>
                            <th>Comprovante PIX</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passagens as $passagem): ?>
                            <tr>
                                <td><?= htmlspecialchars($passagem->getNome()); ?></td>
                                <td><?= htmlspecialchars($passagem->getCpf()); ?></td>
                                <td><?= htmlspecialchars($passagem->getViagem()->getCidadeOrigem()); ?> → <?= htmlspecialchars($passagem->getViagem()->getCidadeDestino()); ?></td>
                                <td><?= htmlspecialchars($passagem->getDataVenda()); ?></td>
                                <td>R$ <?= number_format($passagem->getValor(), 2, ',', '.'); ?></td>
                                <td>
                                    <?php if ($passagem->getCompPix()): ?>
                                        <a href="<?= BASEURL ?>/uploads/<?= htmlspecialchars($passagem->getCompPix()); ?>" target="_blank">Ver</a>
                                    <?php else: ?>
                                        Não enviado
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Nenhuma passagem encontrada.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once(__DIR__ . "/../include/footer.php"); ?>
</div>
