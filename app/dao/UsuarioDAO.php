<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Usuario.php");

class UsuarioDAO {

    //Método para listar os usuários a partir da base de dados
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u ORDER BY u.nome";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapUsuarios($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u" .
               " WHERE u.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1)
            return $usuarios[0];
        elseif(count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
    }


    //Método para buscar um usuário por seu email e senha
    public function findByEmailSenha(string $email, string $senha) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u" .
               " WHERE BINARY u.email = ? AND BINARY u.senha = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$email, $senha]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1) {
            return $usuarios[0];
        } elseif(count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByEmailSenha()" . 
            " - Erro: mais de um usuário encontrado.");
    }

    //Método para inserir um Usuario
    public function insert(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO usuarios (nome, tipo, cpf, email, senha, rg, tel_fixo, tel_celular, situacao)" .
               " VALUES (:nome, :tipo, :cpf, :email, :senha, :rg, :TelFixo, :TelCelular, :situacao)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("tipo", $usuario->getTipo());   
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", $usuario->getSenha());
        $stm->bindValue("rg", $usuario->getRg());
        $stm->bindValue("TelFixo", $usuario->getTelFixo());
        $stm->bindValue("TelCelular", $usuario->getTelCelular());
        $stm->bindValue("situacao", $usuario->getSituacao());
        $stm->execute();
    }

    //Método para atualizar um Usuario
    public function update(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET nome = :nome, tipo = :tipo," . 
                "cpf = :cpf,  email = :email,  senha = :senha, rg = :rg, tel_fixo = :TelFixo, tel_celular = :TelCel, situacao = :situacao " .   
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("tipo", $usuario->getTipo());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", $usuario->getSenha());
        $stm->bindValue("rg", $usuario->getRg());
        $stm->bindValue("TelFixo", $usuario->getTelFixo());
        $stm->bindValue("TelCel", $usuario->getTelCelular());
        $stm->bindValue("situacao", $usuario->getSituacao());
        $stm->bindValue("id", $usuario->getId());

        $stm->execute();
    }

    //Método para excluir um Usuario pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM usuarios WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    
    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapUsuarios($result) {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['id']);
            $usuario->setNome($reg['nome']);
            $usuario->setTipo($reg['tipo']);
            $usuario->setCpf($reg['cpf']);
            $usuario->setEmail($reg['email']);
            $usuario->setSenha($reg['senha']);
            $usuario->setRg($reg['rg']);
            $usuario->setTelFixo($reg['tel_fixo']);
            $usuario->setTelCelular($reg['tel_celular']);
            $usuario->setSituacao($reg['situacao']);

            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

}