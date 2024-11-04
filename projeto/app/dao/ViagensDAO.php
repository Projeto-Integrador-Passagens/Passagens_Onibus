<?php
# Nome do arquivo: ViagensDAO.php
# Objetivo: classe DAO para o model de Viagens

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Viagens.php");

class ViagensDAO {

  // Método para listar os viagem a partir da base de dados
  public function listByUsuario($idUsuario) {
    $conn = Connection::getConn();

    $sql = "SELECT * FROM viagens ORDER BY data_horario";
    $stm = $conn->prepare($sql);    
    $stm->execute();
    $result = $stm->fetchAll();
    
    return $this->mapViagens($result);
}

    // Método para buscar uma viagem por seu ID
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM viagens WHERE id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $viagens = $this->mapViagens($result);

        if(count($viagens) == 1)
            return $viagens[0];
        elseif(count($viagens) == 0)
            return null;

        die("ViagensDAO.findById() - Erro: mais de uma viagem encontrada.");
    }

    // Método para inserir uma viagem
    public function insert(Viagens $viagem) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO viagens (onibus_id, data_horario, cidade_origem, cidade_destino, preco, total_passagens, situacao)" .
               " VALUES (:onibus_id, :data_horario, :cidade_origem, :cidade_destino, :preco, :total_passagens, :situacao)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("onibus_id", $viagem->getOnibusId());
        $stm->bindValue("data_horario", $viagem->getDataHorario());
        $stm->bindValue("cidade_origem", $viagem->getCidadeOrigem());   
        $stm->bindValue("cidade_destino", $viagem->getCidadeDestino());
        $stm->bindValue("preco", $viagem->getPreco());
        $stm->bindValue("total_passagens", $viagem->getTotalPassagens());
        $stm->bindValue("situacao", $viagem->getSituacao());
        $stm->execute();
    }

    // Método para atualizar uma viagem
    public function update(Viagens $viagem) {
        $conn = Connection::getConn();

        $sql = "UPDATE viagens SET onibus_id = :onibus_id, data_horario = :data_horario, cidade_origem = :cidade_origem, cidade_destino = :cidade_destino," .
               " preco = :preco, total_passagens = :total_passagens, situacao = :situacao WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("onibus_id", $viagem->getOnibusId());
        $stm->bindValue("data_horario", $viagem->getDataHorario());
        $stm->bindValue("cidade_origem", $viagem->getCidadeOrigem());
        $stm->bindValue("cidade_destino", $viagem->getCidadeDestino());
        $stm->bindValue("preco", $viagem->getPreco());
        $stm->bindValue("total_passagens", $viagem->getTotalPassagens());
        $stm->bindValue("situacao", $viagem->getSituacao());
        $stm->bindValue("id", $viagem->getId());

        $stm->execute();
    }

    // Método para excluir uma viagem pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM viagens WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    
    // Método para converter um registro da base de dados em um objeto Viagens
    private function mapViagens($result) {
        $viagens = array();
        foreach ($result as $reg) {
            $viagem = new Viagens();
            $viagem->setId($reg['id']);
            $viagem->setOnibusId($reg['onibus_id']);
            $viagem->setDataHorario($reg['data_horario']);
            $viagem->setCidadeOrigem($reg['cidade_origem']);
            $viagem->setCidadeDestino($reg['cidade_destino']);
            $viagem->setPreco($reg['preco']);
            $viagem->setTotalPassagens($reg['total_passagens']);
            $viagem->setSituacao($reg['situacao']);

            array_push($viagens, $viagem);
        }

        return $viagens;
    }
}
