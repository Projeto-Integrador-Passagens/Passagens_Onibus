<?php
# Classe controller para Venda de Passagens
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/PassagemDAO.php");
require_once(__DIR__ . "/../dao/ViagensDAO.php");
require_once(__DIR__ . "/../service/PassagemService.php");
require_once(__DIR__ . "/../model/Passagem.php");
require_once(__DIR__ . "/../model/Viagens.php");

class PassagemController extends Controller {

    private PassagemDAO $passagemDao;
    private ViagensDAO $viagemDao;
    private PassagemService $passagemService;

    // Construtor
    public function __construct() {
        $this->passagemDao = new PassagemDAO();
        $this->viagemDao = new ViagensDAO();
        $this->passagemService = new PassagemService();

        $this->handleAction();
    }

    // Método para vender passagem
    protected function vender($idViagem=0, $msgErro = "") {
        if (!$this->usuarioLogado()) 
            exit;

        if(! $idViagem)
            $idViagem = isset($_GET['id_viagem']) ? $_GET['id_viagem'] : 0;

        // Buscar detalhes da viagem
        $viagem = $this->viagemDao->findById($idViagem);
        if (!$viagem) {
            echo "Viagem não encontrada.";
            exit;
        }


        $dados["viagem"] = $viagem;
        $this->loadView("passagem/form.php", $dados, $msgErro);
    }

    public function salvarCompra() {
$idViagem = isset($_POST['viagens_id']) ? $_POST['viagens_id'] : 0;  // A captura do ID da viagem
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : NULL;  // Captura e limpa o nome do passageiro
    $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : NULL;  // Captura e limpa o CPF do passageiro


        $passagem = new Passagem();
        $passagem->setNome($nome);
        $passagem->setCpf($cpf);

        $viagem = new Viagens();

        $passagem->setViagem($viagem);

        $usuario = new Usuario();
        $usuario->setId($this->getIdUsuarioLogado());
        $passagem->setUsuario($usuario);


        // Validar a venda
        $erros = $this->passagemService->validarVenda($passagem);

        if (empty($erros)) {
            try {
                $this->passagemDao->insert($passagem);
                
                //Redirecionamento para a página de acompanhamento das passagens
                header("location: " . BASEURL . "/controller/PassagemController.php?action=listarPedidosUsuario");
            } catch (PDOException $e) {
                $erros[] = "Erro ao processar a venda: " . $e->getMessage();
            }
        }

        if (!empty($erros)) {
            $msgsErro = implode("<br>", $erros);
            $this->vender($idViagem, $msgsErro);            
        }


    }

    private function listarPedidosUsuario() {
        echo "Chamou listarPedidosUsuario";
        exit;
    }

    private function listarPedidosMotorista() {
        echo "Chamou listarPedidosMostorista";
        exit;
    }


    // Método para buscar uma venda pelo ID
    private function findVendaById() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        return $this->passagemDao->findById($id);
    }

}
# Criar objeto da classe para executar o construtor
new PassagemController();
