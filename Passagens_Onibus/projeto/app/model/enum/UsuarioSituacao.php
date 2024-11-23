<?php
#Nome do arquivo: UsuarioSituacao.php
#Objetivo: classe Enum para a situação do model de Usuario


class UsuarioSituacao {

    
    const ATIVO = "ATIVO";
    const INATIVO = "INATIVO";

    public static function getAllAsArray() {
        return [UsuarioSituacao::ATIVO, UsuarioSituacao:: INATIVO];
    }
    
}



