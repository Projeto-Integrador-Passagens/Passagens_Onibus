<?php
# Classe controller para Venda de Passagens
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/PassagemDAO.php");
require_once(__DIR__ . "/../dao/ViagensDAO.php");
require_once(__DIR__ . "/../service/PassagemService.php");
require_once(__DIR__ . "/../service/CompPixService.php");
require_once(__DIR__ . "/../model/Passagem.php");
require_once(__DIR__ . "/../model/Viagens.php");


class PassagemController extends Controller
{

    private PassagemDAO $passagemDao;
    private ViagensDAO $viagemDao;
    private PassagemService $passagemService;
    private CompPixService $compPixService;

    // Construtor
    public function __construct()
    {
        $this->passagemDao = new PassagemDAO();
        $this->viagemDao = new ViagensDAO();
        $this->passagemService = new PassagemService();
        $this->compPixService = new CompPixService();

        $this->handleAction();
    }

    // Método para vender passagem
    protected function vender($idViagem = 0, $msgErro = "")
    {
        if (!$this->usuarioLogado())
            exit;

        if (! $idViagem)
            $idViagem = isset($_GET['id']) ? $_GET['id'] : 0;

        // Buscar detalhes da viagem
        $viagem = $this->viagemDao->findById($idViagem);
        if (!$viagem) {
            echo "Viagem não encontrada.";
            exit;
        }


        $dados["viagem"] = $viagem;
        $this->loadView("passagem/form.php", $dados, $msgErro);
    }

    public function salvarCompra()
    {

        $idViagem = isset($_GET['id']) ? $_GET['id'] : 0;


        $viagem = $this->viagemDao->findById($idViagem);

        $idViagem = $viagem->getId();
        $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
        $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : null;
        $compPix = isset($_FILES['compPix']) ? $_FILES['compPix'] : [];

        // Inicialização de objetos
        $passagem = new Passagem();
        $usuario = new Usuario();

        $viagem->setId($idViagem);
        $usuario->setId($this->getIdUsuarioLogado());

        $passagem->setNome($nome);
        $passagem->setCpf($cpf);
        $passagem->setViagem($viagem);
        $passagem->setUsuario($usuario);

        // Validar a venda
        $erros = $this->passagemService->validarVenda($passagem, $compPix);

        if (empty($erros)) {
            // Salvar comprovante PIX
            $nomeArquivo = $this->compPixService->salvarArquivo($compPix);
            if ($nomeArquivo) {
                $passagem->setCompPix($nomeArquivo);
            } else {
                $erros[] = "Erro ao salvar o comprovante.";
            }

            // Persistir a venda se não houver erros
            if (empty($erros)) {
                try {
                    $this->passagemDao->insert($passagem);

                    // Redirecionar após o sucesso
                    header("location: " . BASEURL . "/controller/HomeController.php?action=home");
                    exit;
                } catch (PDOException $e) {
                    $erros[] = "Erro ao processar a venda: " . $e->getMessage();
                }
            }
        }


        // Preparar dados para exibição na view
        $dados = [
            'viagem' => $viagem,
            'nome' => $nome,
            'cpf' => $cpf,
        ];
        $msgErro = implode("<br>", $erros);

        // Recarregar a tela com os erros
        $this->loadView("passagem/form.php", $dados, $msgErro);
    }




   // Listar pedidos de passagens do usuário
// Listar pedidos de passagens do usuário
// No PassagemController.php

// Listar pedidos de passagens do usuário
public function listarPedidosUsuario() 
{
    if (!$this->usuarioLogado()) 
        exit;

    $idUsuario = $this->getIdUsuarioLogado();
    
    try {
        // Buscar todas as passagens do usuário
        $passagens = $this->passagemDao->findByUsuarioId($idUsuario);
        
        // Preparar dados para a view
        $dados["passagens"] = $passagens;
        $this->loadView("passagem/lista_usuario.php", $dados);
    } catch (Exception $e) {
        $dados["passagens"] = [];
        $msgErro = "Ocorreu um erro ao buscar as passagens: " . $e->getMessage();
        $this->loadView("passagem/lista_usuario.php", $dados, $msgErro);
    }
}

// Listar vendas de passagens das viagens do motorista
public function listarPedidosMotorista() 
{
    if (!$this->usuarioLogado()) 
        exit;

    $idMotorista = $this->getIdUsuarioLogado();
    
    try {
        // Buscar todas as passagens vendidas para as viagens do motorista
        $passagens = $this->passagemDao->findByMotoristaId($idMotorista);
        
        // Preparar dados para a view
        $dados["passagens"] = $passagens;
        $this->loadView("passagem/lista_motorista.php", $dados);
    } catch (Exception $e) {
        $dados["passagens"] = [];
        $msgErro = "Ocorreu um erro ao buscar as vendas: " . $e->getMessage();
        $this->loadView("passagem/lista_motorista.php", $dados, $msgErro);
    }
}



    // Método para buscar uma venda pelo ID
    private function findVendaById()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        return $this->passagemDao->findById($id);
    }
}
# Criar objeto da classe para executar o construtor
new PassagemController();
