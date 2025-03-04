<?php
#Nome do arquivo: PassagemDAO.php
#Objetivo: classe DAO para o model de Passagem

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Passagem.php");

class PassagemDAO
{

    //Método para listar as vendas a partir da base de dados
    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT 
            p.*, 
            vg.preco,
            vg.cidade_origem,
            vg.cidade_destino
        FROM passagens p
        JOIN viagens vg ON p.viagens_id = vg.id
        ORDER BY p.data_venda DESC";

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapVendas($result);
    }

    public function listByUsuarioId()
    {
        $conn = Connection::getConn();

        $sql = "SELECT 
            p.*, 
            vg.preco,
            vg.cidade_origem,
            vg.cidade_destino
        FROM passagens p
        JOIN viagens vg ON p.viagens_id = vg.id
        WHERE p.usuarios_id = :usuarioId
        ORDER BY p.data_venda DESC";

        $stm = $conn->prepare($sql);
        $stm->bindValue("usuarioId", $_SESSION[SESSAO_USUARIO_ID]);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapVendas($result);
    }


    public function listPassageirosByUsuario($idViagem)
    {
        $conn = Connection::getConn();

        $sql = "SELECT p.id, p.nome, p.cpf, p.data_venda, p.compPix 
        FROM passagens p
        JOIN viagens v ON p.viagens_id = v.id
        WHERE v.id = :idViagem
        ORDER BY p.usuarios_id DESC";
        $stm = $conn->prepare($sql);
        $stm->bindValue("idViagem", $idViagem);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapVendas($result);
    }

    //Método para buscar uma venda por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vendas v" .
            " WHERE v.id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $passagem = $this->mapVendas($result);

        if (count($passagem) == 1)
            return $passagem[0];
        elseif (count($passagem) == 0)
            return null;

        die("PassagemDAO.findById()" .
            " - Erro: mais de uma venda encontrada.");
    }

    //Método para inserir uma Venda
    public function insert(Passagem $passagem)
    {
        $conn = Connection::getConn();

        $viagem = $passagem->getViagem();


        $sql = "INSERT INTO passagens (viagens_id, usuarios_id, nome, cpf, data_venda, valor, compPix)" .
            " VALUES (:viagens_id, :usuarios_id, :nome, :cpf, CURRENT_DATE, :valor, :compPix)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("viagens_id", $viagem->getId());
        $stm->bindValue("usuarios_id", $passagem->getUsuario()->getId());
        $stm->bindValue("nome", $passagem->getNome());
        $stm->bindValue("cpf", $passagem->getCpf());
        $stm->bindValue("valor", $passagem->getViagem()->getPreco());
        $stm->bindValue("compPix", $passagem->getCompPix());
        $stm->execute();
    }

    //Método para atualizar uma Venda
    public function update(Passagem $passagem)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE passagens SET preco = :preco, quantidade = :quantidade, data_venda = :data_venda WHERE id = :id";


        $stm = $conn->prepare($sql);
        $stm->bindValue("preco", $passagem->getValor());
        $stm->bindValue("quantidade", $passagem->getQuantidade());
        $stm->bindValue("data_venda", $passagem->getDataVenda());
        $stm->bindValue("id", $passagem->getId());

        $stm->execute();
    }

    //Método para excluir uma Venda pelo seu ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM passagens WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    //Método para converter um registro da base de dados em um objeto Venda
    private function mapVendas($result)
    {
        $passagens = [];

        foreach ($result as $reg) {
            $passagem = new Passagem();
            $passagem->setId($reg['id']);
            $passagem->setNome($reg['nome']);
            $passagem->setCpf($reg['cpf']);
            $passagem->setValor($reg['preco'] ?? 0); // Usa 0 se não existir
            $passagem->setDataVenda($reg['data_venda']);
            $passagem->setCompPix($reg['compPix']);

            $viagem = new Viagens();
            $viagem->setId($reg['viagens_id'] ?? 0);
            $viagem->setPreco($reg['preco'] ?? 0);
            $viagem->setCidadeDestino($reg['cidade_destino'] ?? 'Não informado');
            $viagem->setCidadeOrigem($reg['cidade_origem'] ?? 'Não informado');

            $usuario = new Usuario();
            $usuario->setId($reg['usuarios_id'] ?? 0);

            $passagem->setViagem($viagem);
            $passagem->setUsuario($usuario);

            array_push($passagens, $passagem);
        }

        return $passagens;
    }
}
