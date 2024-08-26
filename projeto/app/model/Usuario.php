<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioPapel.php");

class Usuario {

    private ?int $id;
    private ?string $nome;
    private ?string $login;
    private ?string $senha;
    private ?int $cpf;
    private ?int $rg;
    private ?int $telFixo;
    private ?int $telCelular;
    
    

  
    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of login
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * Set the value of login
     */
    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha(): ?string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */
    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf(): ?int
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf(?int $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of rg
     */
    public function getRg(): ?int
    {
        return $this->rg;
    }

    /**
     * Set the value of rg
     */
    public function setRg(?int $rg): self
    {
        $this->rg = $rg;

        return $this;
    }

    /**
     * Get the value of tel_fixo
     */
    public function getTelFixo(): ?int
    {
        return $this->telFixo;
    }

    /**
     * Set the value of tel_fixo
     */
    public function setTelFixo(?int $telFixo): self
    {
        $this->telFixo = $telFixo;

        return $this;
    }

    /**
     * Get the value of tel_celular
     */
    public function getTelCelular(): ?int
    {
        return $this->telCelular;
    }

    /**
     * Set the value of tel_celular
     */
    public function setTelCelular(?int $telCelular): self
    {
        $this->telCelular = $telCelular;

        return $this;
    }
}