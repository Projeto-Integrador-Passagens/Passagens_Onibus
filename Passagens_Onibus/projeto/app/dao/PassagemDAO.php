<?php
#Nome do arquivo: PassagemDAO.php
#Objetivo: classe DAO para o model de Passagem

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Passagem.php");

class PassagemDAO {

    //Método para listar as vendas a partir da base de dados
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM passagens v ORDER BY v.data DESC";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVendas($result);
    }

    //Método para buscar uma venda por seu ID
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vendas v" .
               " WHERE v.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $passagem = $this->mapVendas($result);

        if(count($passagem) == 1)
            return $passagem[0];
        elseif(count($passagem) == 0)
            return null;

        die("PassagemDAO.findById()" . 
            " - Erro: mais de uma venda encontrada.");
    }

    //Método para inserir uma Venda
    public function insert(Passagem $passagem) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO passagens (viagens_id, usuarios_id, nome, cpf, data_venda)" .
               " VALUES (:viagens_id, :usuarios_id, :nome, :cpf, CURRENT_DATE)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("viagens_id", $passagem->getViagem()->getId());
        $stm->bindValue("usuarios_id", $passagem->getUsuario()->getId());
        $stm->bindValue("nome", $passagem->getNome());
        $stm->bindValue("cpf", $passagem->getCpf());
        $stm->execute();
    }

    //Método para atualizar uma Venda
    public function update(Passagem $passagem) {
        $conn = Connection::getConn();

        $sql = "UPDATE passagens SET preco = :preco, quantidade = :quantidade," . 
                "data = :data" .   
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("preco", $passagem->getValor());
        $stm->bindValue("quantidade", $passagem->getQuantidade());
        $stm->bindValue("data", $passagem->getDataVenda());
        $stm->bindValue("id", $passagem->getId());

        $stm->execute();
    }

    //Método para excluir uma Venda pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM passage WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    
    //Método para converter um registro da base de dados em um objeto Venda
    private function mapVendas($result) {
        $passagem = array();
        foreach ($result as $reg) {
            $passagem = new Passagem();
            $passagem->setId($reg['id']);
            $passagem->setValor($reg['preco']);
            $passagem->setQuantidade($reg['quantidade']);
            $passagem->setDataVenda($reg['data']);

            array_push($passagems, $passagem);
        }

        return $passagems;
    }

}
