<?php
# Classe controller para Onibus
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/OnibusDAO.php");
require_once(__DIR__ . "/../service/OnibusService.php");
require_once(__DIR__ . "/../model/Onibus.php");

class OnibusController extends Controller {

    private OnibusDAO $onibusDao;
    private OnibusService $onibusService;

    // Método construtor do controller - será executado a cada requisição a esta classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        if(! $this->usuarioIsMotorista()) {
            echo "Acesso negado!";
            exit;
        }
            
        $this->onibusDao = new OnibusDAO();
        $this->onibusService = new OnibusService();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        if (! $this->usuarioLogado())
            exit;

        $usuariosId = $this->getIdUsuarioLogado();

        $onibus = $this->onibusDao->listByUsuario($usuariosId);
        $dados["lista"] = $onibus;

        $this->loadView("onibus/list.php", $dados, $msgErro, $msgSucesso);
    }

    protected function save() {
        // Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $modelo = trim($_POST['modelo']) ? trim($_POST['modelo']) : NULL;
        $marca = trim($_POST['marca']) ? trim($_POST['marca']) : NULL;
        $totalAssentos = trim($_POST['total_assentos']) ? trim($_POST['total_assentos']) : NULL;
        //$usuariosId = trim($_POST['usuarios_id']) ? trim($_POST['usuarios_id']) : NULL;

        $usuariosId = $this->getIdUsuarioLogado();

        // Cria objeto Onibus
        $onibus = new Onibus();
        $onibus->setModelo($modelo);
        $onibus->setMarca($marca);
        $onibus->setTotalAssentos($totalAssentos);
        $onibus->setUsuariosId($usuariosId);

        // Validar os dados
        $erros = $this->onibusService->validarDados($onibus);

        if (empty($erros)) {
            // Persiste o objeto
            try {
                if ($dados["id"] == 0) {  // Inserindo
                    $this->onibusDao->insert($onibus);
                } else { // Alterando
                    $onibus->setId($dados["id"]);
                    $this->onibusDao->update($onibus);
                }

                $this->list("", "Ônibus salvo com sucesso.");
                exit;
            } catch (PDOException $e) {
                $erros[] = "Erro ao salvar o ônibus na base de dados: " . $e->getMessage(); 
            }
        }
        // Se há erros, volta para o formulário
        $dados["onibus"] = $onibus;
        $msgsErro = implode("<br>", $erros);
        $this->loadView("onibus/form.php", $dados, $msgsErro);
    }

    protected function create() {
        $dados["id"] = 0;
        $this->loadView("onibus/form.php", $dados);
    }

    private function findOnibusById() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        return $this->onibusDao->findById($id);
    }
    
    protected function delete() {
        $onibus = $this->findOnibusById();
        if ($onibus) {
            // Excluir
            $this->onibusDao->deleteById($onibus->getId());
            $this->list("", "Ônibus excluído com sucesso!");
        } else {
            // Mensagem que não encontrou o ônibus
            $this->list("Ônibus não encontrado!");
        }               
    }

    protected function edit() {
        $onibus = $this->findOnibusById();
        
        if ($onibus) {
            // Setar os dados
            $dados["id"] = $onibus->getId();
            $dados["onibus"] = $onibus;
            $this->loadView("onibus/form.php", $dados);
        } else {
            $this->list("Ônibus não encontrado");
        }
    }
}

// Criar objeto da classe para assim executar o construtor
new OnibusController();
