<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");

include_once(__DIR__ . "/../model/enum/UsuarioSituacao.php");
include_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class UsuarioController extends Controller {

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        //if(! $this->usuarioLogado())
        //    exit;

        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $usuarios = $this->usuarioDao->list();
        //print_r($usuarios);
        $dados["lista"] = $usuarios;

        $this->loadView("usuario/list.php", $dados,  $msgErro, $msgSucesso);

    }

    protected function save() {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $cpf = trim($_POST['cpf']) ? trim($_POST['cpf']) : NULL;
        $rg = trim($_POST['rg']) ? trim($_POST['rg']) : NULL;
        $telFixo = trim($_POST['telfixo']) ? trim($_POST['telfixo']) : NULL;
        $telCelular = trim($_POST['telcelular']) ? trim($_POST['telcelular']) : NULL;
        $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;

        //Cria objeto Usuario
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setRg($rg);
        $usuario->setCpf($cpf);
        $usuario->setTelCelular($telCelular);
        $usuario->setTelFixo($telFixo);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);

        //Validar os dados
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);

        if(empty($erros)) {
            //Persiste o objeto
            try {
                if($dados["id"] == 0) {  //Inserindo
                    $usuario->setTipo(UsuarioTipo::CLIENTE);
                    $usuario->setSituacao(UsuarioSituacao::ATIVO);

                    $this->usuarioDao->insert($usuario);
                } else { //Alterando
                    $usuario->setId($dados["id"]);
                    $this->usuarioDao->update($usuario);
                }

                //TODO - Enviar mensagem de sucesso
                $msg = "Usuário salvo com sucesso.";
                header("location: " . LOGIN_PAGE);
                exit;
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar o usuário na base de dados." . $e->getMessage());                
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário
        $dados["usuario"] = $usuario;
        $dados["confSenha"] = $confSenha;
        
        $msgsErro = implode("<br>", $erros);
        $this->loadView("usuario/form.php", $dados, $msgsErro);
    }


     protected function create() {
        $dados["id"] = 0;
        $this->loadView("usuario/form.php", $dados);
     }

    //Método para buscar o usuário com base no ID recebido por parâmetro GET
    private function findUsuarioById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $usuario = $this->usuarioDao->findById($id);
        return $usuario;
    }
    


}


#Criar objeto da classe para assim executar o construtor
new UsuarioController();
