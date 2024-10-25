<?php
# Nome do arquivo: OnibusDAO.php
# Objetivo: classe DAO para o model de Onibus

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Onibus.php");

class OnibusDAO {

    // Método para listar os ônibus a partir da base de dados
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM onibus ORDER BY modelo";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapOnibus($result);
    }

    // Método para buscar um ônibus por seu ID
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM onibus WHERE id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $onibus = $this->mapOnibus($result);

        if(count($onibus) == 1)
            return $onibus[0];
        elseif(count($onibus) == 0)
            return null;

        die("OnibusDAO.findById() - Erro: mais de um ônibus encontrado.");
    }

    // Método para inserir um ônibus
    public function insert(Onibus $onibus) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO onibus (modelo, marca, total_assentos, usuarios_id) VALUES (:modelo, :marca, :total_assentos, :usuarios_id)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("modelo", $onibus->getModelo());
        $stm->bindValue("marca", $onibus->getMarca());   
        $stm->bindValue("total_assentos", $onibus->getTotalAssentos());
        $stm->bindValue("usuarios_id", $onibus->getUsuariosId());
        $stm->execute();
    }

    // Método para atualizar um ônibus
    public function update(Onibus $onibus) {
        $conn = Connection::getConn();

        $sql = "UPDATE onibus SET modelo = :modelo, marca = :marca, total_assentos = :total_assentos, usuarios_id = :usuarios_id WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("modelo", $onibus->getModelo());
        $stm->bindValue("marca", $onibus->getMarca());
        $stm->bindValue("total_assentos", $onibus->getTotalAssentos());
        $stm->bindValue("usuarios_id", $onibus->getUsuariosId());
        $stm->bindValue("id", $onibus->getId());

        $stm->execute();
    }

    // Método para excluir um ônibus pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM onibus WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    
    // Método para converter um registro da base de dados em um objeto Onibus
    private function mapOnibus($result) {
        $onibus = array();
        foreach ($result as $reg) {
            $bus = new Onibus();
            $bus->setId($reg['id']);
            $bus->setModelo($reg['modelo']);
            $bus->setMarca($reg['marca']);
            $bus->setTotalAssentos($reg['total_assentos']);
            $bus->setUsuariosId($reg['usuarios_id']);

            array_push($onibus, $bus);
        }

        return $onibus;
    }
}
