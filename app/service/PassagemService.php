<?php

require_once(__DIR__ . "/../model/Passagem.php");

class PassagemService
{
    /* Método para validar os dados da venda que vêm do formulário */
    public function validarVenda(Passagem $passagem, array $compPix)
    {
        $erros = array();

        // Validar campos NOME, CPF e comprovante de pix
        if (!$passagem->getCpf()) {
            array_push($erros, "O campo [Cpf] é obrigatório.");
        }

        if (!$passagem->getNome()) {
            array_push($erros, "O campo [Nome] é obrigatório.");
        }

        if (empty($compPix) || !isset($compPix["size"]) || $compPix["size"] <= 0) {
            array_push($erros, "O campo [Comprovante de Pagamento] é obrigatório.");
        }

        return $erros;
    }
}
