<?php 
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/enum/UsuarioSituacao.php");
include_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class LoginController extends Controller {

    private LoginService $loginService;
    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;

    public function __construct() {
        $this->loginService = new LoginService();
        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();
        
        $this->handleAction();
    }

    protected function login() {
        $this->loadView("login/login.php", []);
    }

    /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logon() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;

        //Validar os campos
        $erros = $this->loginService->validarCampos($email, $senha);
        if(empty($erros)) {
            //Valida o login a partir do banco de dados
            $usuario = $this->usuarioDao->findByEmailSenha($email, $senha);
            if($usuario) {
                //Se encontrou o usuário, salva a sessão e redireciona para a HOME do sistema
                $this->loginService->salvarUsuarioSessao($usuario);

                header("location: " . HOME_PAGE);
                exit;
            } else {
                $erros = ["Email ou senha informados são inválidos!"];
            }
        }

        //Se há erros, volta para o formulário            
        $msg = implode("<br>", $erros);
        $dados["email"] = $email;
        $dados["senha"] = $senha;

        $this->loadView("login/login.php", $dados, $msg);
    }

     /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logout() {
        $this->loginService->removerUsuarioSessao();

        $this->loadView("login/login.php", [], "", "Usuário deslogado com suscesso!");
    }

    protected function createCadastro() {
        $dados["id"] = 0;

            $dados["tipos"] = Tipo::getAllAsArray();
            $dados["situacoes"] = UsuarioSituacao::getAllAsArray();

        $this->loadView("login/cadastro.php", $dados);
     }

     protected function saveCadastro() {
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
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
        $situacao = isset($_POST['situacao']) ? $_POST['situacao'] : NULL;

        //Cria objeto Usuario
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setRg($rg);
        $usuario->setCpf($cpf);
        $usuario->setTelCelular($telCelular);
        $usuario->setTelFixo($telFixo);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);

        if($this->usuarioLogadoStatus())
            $usuario->setTipo($tipo);
        else 
            $usuario->setTipo(Tipo::CLIENTE);

        if($this->usuarioLogadoStatus())
            $usuario->setSituacao($situacao);
        else 
            $usuario->setSituacao(UsuarioSituacao::ATIVO);


        //Validar os dados
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);

        if(empty($erros)) {
            //Persiste o objeto
            try {
                if($dados["id"] == 0) {  //Inserindo
                    $this->usuarioDao->insert($usuario);
                } else { //Alterando
                    $usuario->setId($dados["id"]);
                    $this->usuarioDao->update($usuario);
                }

                if($this->usuarioLogadoStatus()) {
                    $msg = "Usuário salvo com sucesso.";
                    header("location: " . HOME_PAGE);
                } else                
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

            $dados["tipos"] = Tipo::getAllAsArray();
            $dados["situacoes"] = UsuarioSituacao::getAllAsArray();
        
        $msgsErro = implode("<br>", $erros);
        $this->loadView("login/cadastro.php", $dados, $msgsErro);
    }

}


#Criar objeto da classe para assim executar o construtor
new LoginController();
