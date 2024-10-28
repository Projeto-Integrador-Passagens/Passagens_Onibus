<?php

require_once(__DIR__ . "/../model/Onibus.php");

class OnibusService {
    

    /* Método para validar os dados do ônibus que vêm do formulário */
    public function validarDados(Onibus $onibus) {
        $erros = array();

        // Validar campos vazios
        if(!$onibus->getModelo())
            array_push($erros, "O campo [Modelo] é obrigatório.");

        if(!$onibus->getMarca())
            array_push($erros, "O campo [Marca] é obrigatório.");

        if(!$onibus->getTotalAssentos())
            array_push($erros, "O campo [Total de Assentos] é obrigatório.");
        return $erros;
    }

}
