<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/estilizacao/list.css">


<div class="container">
    <h3 class="text-center mt-4 mb-4">Minhas Passagens</h3>
    <?php if (isset($msgErro) && !empty($msgErro)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $msgErro ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <?php if (isset($passagens) && is_array($passagens) && count($passagens) > 0) : ?>
                <table id="tabPassagens" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Origem → Destino</th>
                            <th>Data da Viagem</th>
                            <th>Horário</th>
                            <th>Data da Compra</th>
                            <th>Valor</th>
                            <th>Comprovante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passagens as $passagem) : ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($passagem->getViagem()->getCidadeOrigem()); ?> → 
                                    <?= htmlspecialchars($passagem->getViagem()->getCidadeDestino()); ?>
                                </td>
                                <td><?= htmlspecialchars($passagem->getViagem()->getDataViagem()); ?></td>
                                <td><?= htmlspecialchars($passagem->getViagem()->getHoraSaida()); ?></td>
                                <td><?= htmlspecialchars($passagem->getDataVenda()); ?></td>
                                <td>R$ <?= number_format($passagem->getValor(), 2, ',', '.'); ?></td>
                                <td>
                                    <?php if ($passagem->getCompPix()) : ?>
                                        <a href="<?= BASEURL ?>/uploads/<?= htmlspecialchars($passagem->getCompPix()); ?>" 
                                           target="_blank" 
                                           class="btn btn-sm btn-primary">
                                            Ver comprovante
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">Não enviado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert alert-info text-center">
                    Você ainda não possui passagens compradas.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once(__DIR__ . "/../include/footer.php"); ?>
