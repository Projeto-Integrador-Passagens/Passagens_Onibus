<?php
# Classe controller para Viagens
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/ViagensDAO.php");
require_once(__DIR__ . "/../dao/PassagemDAO.php");
require_once(__DIR__ . "/../dao/OnibusDAO.php");
require_once(__DIR__ . "/../service/ViagensService.php");
require_once(__DIR__ . "/../model/Viagens.php");
require_once(__DIR__ . "/../model/enum/ViagemSituacao.php");

class ViagensController extends Controller {

    private ViagensDAO $viagensDao;
    private PassagemDAO $passagemDao;
    private ViagensService $viagensService;
    private OnibusDAO $onibusDao;

    // Método construtor do controller - será executado a cada requisição a esta classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        if(! $this->usuarioIsMotorista()) {
            echo "Acesso negado!";
            exit;
        }

        $this->viagensDao = new ViagensDAO();
        $this->passagemDao = new PassagemDAO();
        $this->viagensService = new ViagensService();
        $this->onibusDao = new OnibusDAO();

        $this->handleAction();
    }

    protected function listMyViagens() {
        if(! $this->usuarioLogado())
            exit;

            $idUsuario = $this->getIdUsuarioLogado();

        $viagens = $this->viagensDao->listByUsuario($idUsuario);

        $dados["lista"] = $viagens;

        $this->loadView("viagens/list.php", $dados, "");

    }

    protected function listPassageirosByUsuario() {
        if(! $this->usuarioLogado())
            exit;

        $idViagem = isset($_GET['id']) ? $_GET['id'] : null;

        $passageiros = $this->passagemDao->listPassageirosByUsuario($idViagem);

        $dados["lista"] = $passageiros;

        $this->loadView("viagens/listPassageiros.php", $dados, "");

    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        if (! $this->usuarioLogado())
            exit;

        $usuariosId = $this->getIdUsuarioLogado();

        $viagens = $this->viagensDao->listByUsuario($usuariosId);
        $dados["lista"] = $viagens;

        $this->loadView("viagens/list.php", $dados, $msgErro, $msgSucesso);
    }


    protected function save() {
        // Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $dataHorario = trim($_POST['data_horario']) ? trim($_POST['data_horario']) : NULL;
        $cidadeOrigem = trim($_POST['cidade_origem']) ? trim($_POST['cidade_origem']) : NULL;
        $cidadeDestino = trim($_POST['cidade_destino']) ? trim($_POST['cidade_destino']) : NULL;
        $preco = trim($_POST['preco']) ? trim($_POST['preco']) : NULL;
        $totalPassagens = trim($_POST['total_passagens']) ? trim($_POST['total_passagens']) : NULL;
        $onibusId = is_numeric($_POST['onibus_id']) ? $_POST['onibus_id'] : NULL;

        // Cria objeto Viagens
        $viagem = new Viagens();
        $viagem->setDataHorario($dataHorario);
        $viagem->setCidadeOrigem($cidadeOrigem);
        $viagem->setCidadeDestino($cidadeDestino);
        $viagem->setPreco($preco);
        $viagem->setTotalPassagens($totalPassagens);
        $viagem->setSituacao(ViagemSituacao::PROGRAMADA);

        if($onibusId) {
            $viagem->setOnibus(new Onibus());
            $viagem->getOnibus()->setId($onibusId);
        } else
            $viagem->setOnibus(null);

        // Validar os dados
        $erros = $this->viagensService->validarDados($viagem);

        if (empty($erros)) {
            // Persiste o objeto
            try {
                if ($dados["id"] == 0) {  
                    // Inserindo
                    $this->viagensDao->cadastrarViagem($viagem);
                } else { // Alterando
                    $viagem->setId($dados["id"]);
                    $this->viagensDao->update($viagem);
                }

                $this->list("", "Viagem salva com sucesso.");
                exit;
            } catch (PDOException $e) {
                $erros[] = "Erro ao salvar a viagem na base de dados: " . $e->getMessage(); 
                error_log($e->getMessage());
            }
        }

        // Se há erros, volta para o formulário
        $dados["viagem"] = $viagem;
        $dados["onibusList"] = $this->onibusDao->listByUsuario($this->getIdUsuarioLogado());
        
        $msgErros = implode("<br>", $erros);
        $this->loadView("viagens/form.php", $dados, $msgErros);
    }

    protected function create() {
        $dados["id"] = 0;
        $dados["onibusList"] = $this->onibusDao->listByUsuario($this->getIdUsuarioLogado());

        $this->loadView("viagens/form.php", $dados);
    
    }

    private function findViagemById() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        return $this->viagensDao->findById($id);
    }
    
    protected function delete() {
        $viagem = $this->findViagemById();
        if ($viagem) {
            // Excluir
            $this->viagensDao->deleteById($viagem->getId());
            $this->list("", "Viagem excluída com sucesso!");
        } else {
            // Mensagem que não encontrou a viagem
            $this->list("Viagem não encontrada!");
        }               
    }

    protected function finalizar() {
        $viagem = $this->findViagemById();
        if ($viagem) {
            // Finalizar viagem
            $this->viagensDao->finalizar($viagem->getId());
            $this->list("", "Viagem finalizada com sucesso!");
        } else {
            // Mensagem que não encontrou a viagem
            $this->list("Viagem não encontrada!");
        }               
    }

    protected function edit() {
        $viagem = $this->findViagemById();
        
        if ($viagem) {
            // Setar os dados
            $dados["id"] = $viagem->getId();
            $dados["viagem"] = $viagem;
            $dados["onibusList"] = $this->onibusDao->listByUsuario($this->getIdUsuarioLogado());

            $this->loadView("viagens/form.php", $dados);
        } else {
            $this->list("Viagem não encontrada");
        }
    }
}

// Criar objeto da classe para assim executar o construtor
new ViagensController();
