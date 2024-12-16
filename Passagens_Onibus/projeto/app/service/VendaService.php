<?php

require_once(__DIR__ . "/../model/Venda.php");

class VendaService {

    /* Método para validar os dados da venda que vêm do formulário */
    public function validarDados(Venda $venda) {
        $erros = array();

        // Validar campos vazios
        if(!$venda->getValor())
            array_push($erros, "O campo [Preço] é obrigatório.");

        if(!$venda->getQuantidade())
            array_push($erros, "O campo [Quantidade] é obrigatório.");

        if(!$venda->getDataVenda())
            array_push($erros, "O campo [Data] é obrigatório.");
            
        return $erros;
    }

}
