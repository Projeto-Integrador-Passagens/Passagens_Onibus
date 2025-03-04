<?php

require_once(__DIR__ . "/../model/Viagens.php");

class ViagensService {
    
    /* Método para validar os dados da viagem que vêm do formulário */
    public function     validarDados(Viagens $viagem) {
        $erros = array();

        // Validar campos obrigatórios

        if(!$viagem->getDataHorario())
            array_push($erros, "O campo [Data e Horário] é obrigatório.");

        if(!$viagem->getCidadeOrigem())
            array_push($erros, "O campo [Cidade de Origem] é obrigatório.");

        if(!$viagem->getCidadeDestino())
            array_push($erros, "O campo [Cidade de Destino] é obrigatório.");

        if(!$viagem->getPreco())
            array_push($erros, "O campo [Preço] é obrigatório.");

        if(!$viagem->getTotalPassagens())
            array_push($erros, "O campo [Total de Passagens] é obrigatório.");

        if(!$viagem->getOnibus())
            array_push($erros, "O campo [Ônibus] é obrigatório.");
        else {
            //TODO - Validar a capacidade do ônibuco com o total de passagens
            
        }



        return $erros;
    }

}

