<?php
#Nome do arquivo: ViagemSituacao.php
#Objetivo: classe Enum para as situações das viagens

class ViagemSituacao {

    const PROGRAMADA = "PROGRAMADA";
    const FINALIZADA = "FINALIZADA";

    public static function getAllAsArray() {
        return [ViagemSituacao::PROGRAMADA, ViagemSituacao::FINALIZADA];
    }

}

