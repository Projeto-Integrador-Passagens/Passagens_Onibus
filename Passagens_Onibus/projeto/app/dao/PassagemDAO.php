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

        $vendas = $this->mapVendas($result);

        if(count($vendas) == 1)
            return $vendas[0];
        elseif(count($vendas) == 0)
            return null;

        die("VendaDAO.findById()" . 
            " - Erro: mais de uma venda encontrada.");
    }

    //Método para inserir uma Venda
    public function insert(Passagem $venda) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO vendas (preco, quantidade, data)" .
               " VALUES (:preco, :quantidade, :data)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("preco", $venda->getValor());
        $stm->bindValue("quantidade", $venda->getQuantidade());
        $stm->bindValue("data", $venda->getDataVenda());
        $stm->execute();
    }

    //Método para atualizar uma Venda
    public function update(Passagem $venda) {
        $conn = Connection::getConn();

        $sql = "UPDATE vendas SET preco = :preco, quantidade = :quantidade," . 
                "data = :data" .   
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("preco", $venda->getValor());
        $stm->bindValue("quantidade", $venda->getQuantidade());
        $stm->bindValue("data", $venda->getDataVenda());
        $stm->bindValue("id", $venda->getId());

        $stm->execute();
    }

    //Método para excluir uma Venda pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM vendas WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    
    //Método para converter um registro da base de dados em um objeto Venda
    private function mapVendas($result) {
        $vendas = array();
        foreach ($result as $reg) {
            $venda = new Passagem();
            $venda->setId($reg['id']);
            $venda->setValor($reg['preco']);
            $venda->setQuantidade($reg['quantidade']);
            $venda->setDataVenda($reg['data']);

            array_push($vendas, $venda);
        }

        return $vendas;
    }

}
