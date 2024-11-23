<?php

require_once(__DIR__ . "/../model/Viagens.php");
require_once(__DIR__ . "/../dao/OnibusDAO.php"); // Inclua a classe OnibusDAO para acessar a capacidade do ônibus

class ViagensService {
    
    /* Método para validar os dados da viagem que vêm do formulário */
    public function validarDados(Viagens $viagem) {
        $erros = array();

        // Validar campos obrigatórios
        if (!$viagem->getOnibusId()) {
            $erros[] = "O campo [Ônibus ID] é obrigatório.";
        }

        if (!$viagem->getDataHorario()) {
            $erros[] = "O campo [Data e Horário] é obrigatório.";
        }

        if (!$viagem->getCidadeOrigem()) {
            $erros[] = "O campo [Cidade de Origem] é obrigatório.";
        }

        if (!$viagem->getCidadeDestino()) {
            $erros[] = "O campo [Cidade de Destino] é obrigatório.";
        }

        if (!$viagem->getPreco()) {
            $erros[] = "O campo [Preço] é obrigatório.";
        }

        if (!$viagem->getTotalPassagens()) {
            $erros[] = "O campo [Total de Passagens] é obrigatório.";
        }

        if (!$viagem->getSituacao()) {
            $erros[] = "O campo [Situação] é obrigatório.";
        }

        // Verificar a capacidade do ônibus se o ID do ônibus foi preenchido
        if ($viagem->getOnibusId()) {
            $onibusDao = new OnibusDAO();
            $capacidade = $onibusDao->getCapacidadeById($viagem->getOnibusId());

            if ($capacidade === null) {
                $erros[] = "Ônibus selecionado não é válido.";
            } elseif ($viagem->getTotalPassagens() > $capacidade) {
                $erros[] = "Número de assentos solicitados excede a capacidade máxima do ônibus (máximo: $capacidade).";
            }
        }

        return $erros;
    }
}
