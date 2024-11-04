<?php
# Classe controller para Viagens
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/ViagensDAO.php");
require_once(__DIR__ . "/../service/ViagensService.php");
require_once(__DIR__ . "/../model/Viagens.php");

class ViagensController extends Controller {

    private ViagensDAO $viagensDao;
    private ViagensService $viagensService;

    // Método construtor do controller - será executado a cada requisição a esta classe
    public function __construct() {
        $this->viagensDao = new ViagensDAO();
        $this->viagensService = new ViagensService();

        $this->handleAction();
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
        //$onibusId = trim($_POST['onibus_id']) ? trim($_POST['onibus_id']) : NULL;
        $dataHorario = trim($_POST['data_horario']) ? trim($_POST['data_horario']) : NULL;
        $cidadeOrigem = trim($_POST['cidade_origem']) ? trim($_POST['cidade_origem']) : NULL;
        $cidadeDestino = trim($_POST['cidade_destino']) ? trim($_POST['cidade_destino']) : NULL;
        $preco = trim($_POST['preco']) ? trim($_POST['preco']) : NULL;
        $totalPassagens = trim($_POST['total_passagens']) ? trim($_POST['total_passagens']) : NULL;
        $situacao = trim($_POST['situacao']) ? trim($_POST['situacao']) : NULL;

        $onibusId = $this->getIdUsuarioLogado();

        // Cria objeto Viagens
        $viagem = new Viagens();
        $viagem->setOnibusId($onibusId);
        $viagem->setDataHorario($dataHorario);
        $viagem->setCidadeOrigem($cidadeOrigem);
        $viagem->setCidadeDestino($cidadeDestino);
        $viagem->setPreco($preco);
        $viagem->setTotalPassagens($totalPassagens);
        $viagem->setSituacao($situacao);

        // Validar os dados
        $erros = $this->viagensService->validarDados($viagem);

        if (empty($erros)) {
            // Persiste o objeto
            try {
                if ($dados["id"] == 0) {  // Inserindo
                    $this->viagensDao->insert($viagem);
                } else { // Alterando
                    $viagem->setId($dados["id"]);
                    $this->viagensDao->update($viagem);
                }

                $this->list("", "Viagem salva com sucesso.");
                exit;
            } catch (PDOException $e) {
                $erros[] = "Erro ao salvar a viagem na base de dados: " . $e->getMessage(); 
            }
        }

        // Se há erros, volta para o formulário
        $dados["viagem"] = $viagem;
        $dados["erros"] = implode("<br>", $erros);
        $this->loadView("viagens/form.php", $dados);
    }

    protected function create() {
        $dados["id"] = 0;
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

    protected function edit() {
        $viagem = $this->findViagemById();
        
        if ($viagem) {
            // Setar os dados
            $dados["id"] = $viagem->getId();
            $dados["viagem"] = $viagem;
            $this->loadView("viagens/form.php", $dados);
        } else {
            $this->list("Viagem não encontrada");
        }
    }
}

// Criar objeto da classe para assim executar o construtor
new ViagensController();
