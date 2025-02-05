<?php
# Nome do arquivo: PassagemDAO.php
# Objetivo: classe DAO para o model de Passagem

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Passagem.php");
include_once(__DIR__ . "/../model/Viagens.php");
include_once(__DIR__ . "/../model/Usuario.php");

class PassagemDAO
{
    // Método para listar todas as passagens
    public function listarPassagens()
    {
        $conn = Connection::getConn();
        $sql = "SELECT p.*, v.cidade_origem, v.cidade_destino, v.preco, v.id as viagem_id,
                       u.id as usuario_id
                FROM passagens p 
                JOIN viagens v ON p.viagens_id = v.id
                JOIN usuarios u ON p.usuarios_id = u.id";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapVendas($result);
    }

    // Buscar passagens de um motorista específico
    public function findByMotoristaId(int $motoristaId) 
    {
        $conn = Connection::getConn();
        
        $sql = "SELECT p.*,v.id as viagem_id, 
                       u.id as usuario_id
                FROM passagens p
                INNER JOIN viagens v ON p.viagens_id = v.id
                INNER JOIN usuarios u ON p.usuarios_id = u.id
                WHERE v.dono_viagem_id = :motoristaId
                ORDER BY p.data_venda DESC";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":motoristaId", $motoristaId, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapVendas($result);
    }

    // Buscar passagens de um usuário específico
        public function findByUsuarioId(int $usuarioId)
        {
            $conn = Connection::getConn();
            $sql = "SELECT p.*, v.cidade_origem, v.cidade_destino, v.preco, v.id as viagem_id,
                           v.data_viagem, v.hora_saida,
                           u.id as usuario_id
                    FROM passagens p 
                    JOIN viagens v ON p.viagens_id = v.id
                    JOIN usuarios u ON p.usuarios_id = u.id
                    WHERE p.usuarios_id = :usuarioId
                    ORDER BY p.data_venda DESC";
            
            try {
                $stm = $conn->prepare($sql);
                $stm->bindValue(":usuarioId", $usuarioId, PDO::PARAM_INT);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $this->mapVendas($result);
            } catch (PDOException $e) {
                error_log("Erro ao buscar passagens do usuário: " . $e->getMessage());
                throw new Exception("Erro ao buscar passagens");
            }
        }
       
    // Buscar uma passagem por ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();
        $sql = "SELECT p.*, v.cidade_origem, v.cidade_destino, v.preco, v.id as viagem_id,
                       u.id as usuario_id
                FROM passagens p 
                JOIN viagens v ON p.viagens_id = v.id
                JOIN usuarios u ON p.usuarios_id = u.id
                WHERE p.id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll();

        if (count($result) === 1) {
            return $this->mapVendas($result)[0];
        } elseif (count($result) === 0) {
            return null;
        }

        throw new Exception("Erro: mais de uma venda encontrada para o ID informado.");
    }

    // Inserir uma nova passagem
    public function insert(Passagem $passagem)
    {
        $conn = Connection::getConn();
        $viagem = $passagem->getViagem();
    
        $sql = "INSERT INTO passagens (viagens_id, usuarios_id, nome, cpf, data_venda, valor, compPix) 
                VALUES (:viagens_id, :usuarios_id, :nome, :cpf, CURRENT_DATE, :valor, :compPix)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue(":viagens_id", $viagem->getId());
        $stm->bindValue(":usuarios_id", $passagem->getUsuario()->getId());
        $stm->bindValue(":nome", $passagem->getNome());
        $stm->bindValue(":cpf", $passagem->getCpf());
        $stm->bindValue(":valor", $passagem->getViagem()->getPreco());
        $stm->bindValue(":compPix", $passagem->getCompPix());
        $stm->execute();
    
        // RECUPERA O ID GERADO
        $passagem->setId($conn->lastInsertId());
    }
    

    // Atualizar uma passagem existente
    public function update(Passagem $passagem)
    {
        $conn = Connection::getConn();
        $sql = "UPDATE passagens 
                SET nome = :nome,
                    cpf = :cpf,
                    valor = :valor,
                    data_venda = :data_venda,
                    compPix = :compPix
                WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue(":nome", $passagem->getNome());
        $stm->bindValue(":cpf", $passagem->getCpf());
        $stm->bindValue(":valor", $passagem->getValor());
        $stm->bindValue(":data_venda", $passagem->getDataVenda());
        $stm->bindValue(":compPix", $passagem->getCompPix());
        $stm->bindValue(":id", $passagem->getId(), PDO::PARAM_INT);
        
        return $stm->execute();
    }

    // Excluir uma passagem por ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();
        $sql = "DELETE FROM passagens WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    // Mapear os resultados do banco de dados para objetos
    private function mapVendas($result) 
    {
        $passagens = array();
        
        foreach($result as $reg) {
            try {
                $passagem = new Passagem();
                $passagem->setId($reg['id'] ?? null);
                $passagem->setNome($reg['nome'] ?? '');
                $passagem->setCpf($reg['cpf'] ?? '');
                $passagem->setDataVenda($reg['data_venda'] ?? null);
                $passagem->setCompPix($reg['compPix'] ?? null);
                
                // Configurar objeto Viagem
                $viagem = new Viagens();
                $viagem->setId($reg['viagem_id'] ?? $reg['viagens_id'] ?? null);
                $viagem->setCidadeOrigem($reg['cidade_origem'] ?? '');
                $viagem->setCidadeDestino($reg['cidade_destino'] ?? '');
                $viagem->setPreco($reg['preco'] ?? 0);
                if (isset($reg['data_viagem'])) {
                    $viagem->setDataHorario($reg['data_viagem']);
                }
                // Configurar objeto Usuario
                $usuario = new Usuario();
                $usuario->setId($reg['usuario_id'] ?? $reg['usuarios_id'] ?? null);
                
                $passagem->setViagem($viagem);
                $passagem->setUsuario($usuario);
                $passagem->setValor($reg['preco'] ?? 0);
                
                $passagens[] = $passagem;
            } catch (Exception $e) {
                error_log("Erro ao mapear passagem: " . $e->getMessage());
                continue;
            }
        }
        
        return $passagens;
    }
}
