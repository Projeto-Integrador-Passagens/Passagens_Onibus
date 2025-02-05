<?php
#Nome do arquivo: Tipo.php
#Objetivo: classe Enum para os papeis de permissões do model de Usuario

class Tipo {

    const CLIENTE = "CLIENTE";
    const MANTENEDOR = "MANTENEDOR";
    const MOTORISTA = "MOTORISTA";

    public static function getAllAsArray() {
        return [Tipo::CLIENTE, Tipo::MANTENEDOR , TIPO:: MOTORISTA];
    }

}

