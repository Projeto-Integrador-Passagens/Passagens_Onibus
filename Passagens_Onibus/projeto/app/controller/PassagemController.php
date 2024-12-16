<?php
# Classe controller para Venda de Passagens
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/PassagemDAO.php");
require_once(__DIR__ . "/../dao/ViagensDAO.php");
//require_once(__DIR__ . "/../service/VendaService.php");
require_once(__DIR__ . "/../model/Passagem.php");
require_once(__DIR__ . "/../model/Viagens.php");

class PassagemController extends Controller {

    private PassagemDAO $pasasgemDao;
    private ViagensDAO $viagemDao;
    //private VendaService $vendaService;

    // Construtor
    public function __construct() {
        $this->pasasgemDao = new PassagemDAO();
        $this->viagemDao = new ViagensDAO();
        //$this->vendaService = new VendaService();

        $this->handleAction();
    }

    // Método para listar vendas
    protected function list(string $msgErro = "", string $msgSucesso = "") {
        if (!$this->usuarioLogado()) exit;

        $vendas = $this->pasasgemDao->list();
        $dados["lista"] = $vendas;

        $this->loadView("venda/list.php", $dados, $msgErro, $msgSucesso);
    }

    // Método para vender passagem
    protected function vender() {
        if (!$this->usuarioLogado()) 
            exit;

        $idViagem = isset($_GET['id_viagem']) ? $_GET['id_viagem'] : 0;

        // Buscar detalhes da viagem
        $viagem = $this->viagemDao->findById($idViagem);
        if (!$viagem) {
            $this->list("Viagem não encontrada.");
            return;
        }


        $dados["viagem"] = $viagem;
        $this->loadView("passagem/form.php", $dados);

        /*
        $venda = new Venda();
        $venda->setViagem($viagem);
        $venda->setQuantidade($quantidade);
        $venda->setUsuario($this->getUsuarioLogado());

        // Validar a venda
        $erros = $this->vendaService->validarVenda($venda);

        if (empty($erros)) {
            try {
                $this->vendaDao->realizarVenda($venda);
                $this->list("", "Venda realizada com sucesso!");
            } catch (PDOException $e) {
                $erros[] = "Erro ao processar a venda: " . $e->getMessage();
            }
        }

        if (!empty($erros)) {
            $msgsErro = implode("<br>", $erros);
            $dados["venda"] = $venda;
            
        }
        */
    }

    // Método para criar um novo formulário de venda
    protected function create() {
        $dados["viagens"] = $this->vendaDao->listarViagensDisponiveis();
        $this->loadView("venda/form.php", $dados);
    }

    // Método para buscar uma venda pelo ID
    private function findVendaById() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        return $this->vendaDao->findById($id);
    }

    // Método para excluir uma venda
    protected function delete() {
        $venda = $this->findVendaById();
        if ($venda) {
            $this->vendaDao->deleteById($venda->getId());
            $this->list("", "Venda excluída com sucesso!");
        } else {
            $this->list("Venda não encontrada!");
        }
    }

    // Método para editar uma venda
    protected function edit() {
        $venda = $this->findVendaById();

        if ($venda) {
            $dados["id"] = $venda->getId();
            $dados["venda"] = $venda;
            $dados["viagens"] = $this->vendaDao->listarViagensDisponiveis();

            $this->loadView("venda/form.php", $dados);
        } else {
            $this->list("Venda não encontrada");
        }
    }
}

# Criar objeto da classe para executar o construtor
new PassagemController();
