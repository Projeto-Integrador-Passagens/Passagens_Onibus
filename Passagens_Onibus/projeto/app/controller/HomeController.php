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

        $dados['listaCidadeOrigem'] = $this->viagensDao->listOrigens();


        $this->loadView("home/home.php", $dados);
    }

}


#Criar objeto da classe para assim executar o construtor
new HomeController();
