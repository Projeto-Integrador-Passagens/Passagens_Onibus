<?php
    
require_once(__DIR__ . "/../model/Usuario.php");

class UsuarioService {

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Usuario $usuario, ?string $confSenha,) {
        $erros = array();

        //Validar campos vazios
        if(! $usuario->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");

        if(! $usuario->getCpf())
            array_push($erros, "O campo [Cpf] é obrigatório.");

        if(! $usuario->getRg())
            array_push($erros, "O campo [Rg] é obrigatório.");

        /*if(! $usuario->getTelFixo())
            array_push($erros, "O campo [Telefone Fixo] é obrigatório.");*/

        if(! $usuario->getTelCelular())
                array_push($erros, "O campo [Telefone do celular] é obrigatório.");

        if(! $usuario->getEmail())
            array_push($erros, "O campo [Email] é obrigatório.");

        if(! $usuario->getTipo())
            array_push($erros, "O campo [Tipo] é obrigatório.");

        if(! $usuario->getSituacao())
            array_push($erros, "O campo [Situação] é obrigatório.");
        
        if(! $usuario->getSenha())
            array_push($erros, "O campo [Senha] é obrigatório.");

        if(! $confSenha)
            array_push($erros, "O campo [Confirmação da senha] é obrigatório.");

        //Validar se a senha é igual a contra senha
        if($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            array_push($erros, "O campo [Senha] deve ser igual ao [Confirmação da senha].");

        return $erros;
    }

}
