<?php

require_once(__DIR__ . "/../model/Passagem.php");

class PassagemService {

    /* Método para validar os dados da venda que vêm do formulário */
    public function validarVenda(Passagem $passagem) {
        $erros = array();

        // Validar campos NOME e CPF
        if(!$passagem->getCpf())
            array_push($erros, "O campo [Cpf] é obrigatório.");

        if(!$passagem->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");
            
        return $erros;
    }

}
