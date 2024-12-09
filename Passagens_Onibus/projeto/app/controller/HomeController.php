<?php 
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/ViagensDAO.php");

class HomeController extends Controller {

    private ViagensDAO $viagensDao;

    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        $this->viagensDao = new ViagensDAO();

        $this->handleAction();
    }

    protected function home() {

        //Capturar os parâmetros de filtros
        $origem = "";
        $destino = "";
        $data = "";
        if(isset($_GET['origem']))
            $origem = $_GET['origem'];

        if(isset($_GET['destino']))
            $destino = $_GET['destino'];

        if(isset($_GET['data']))
            $data = $_GET['data'];

        $dados['listaViagensDisp'] = $this->viagensDao->listViagensDisp($origem, $destino, $data);
        
        $dados['listaCidadeOrigem'] = $this->viagensDao->listOrigens();

        $dados['listaCidadeDestino'] = $this->viagensDao->listOrigens();


        $this->loadView("home/home.php", $dados);
    }

}


#Criar objeto da classe para assim executar o construtor
new HomeController();
