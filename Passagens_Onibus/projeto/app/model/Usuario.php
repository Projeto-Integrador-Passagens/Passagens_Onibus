<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . '/enum/UsuarioTipo.php');

class Usuario {

    private ?int $id;
    private ?string $nome;
    private ?string $email;
    private ?string $senha;
    private ?string $cpf;
    private ?string $rg;
    private ?string $telFixo;
    private ?string $telCelular;

    private ?string $tipo;
    private ?string $situacao;
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getRg(): ?string
    {
        return $this->rg;
    }

    public function setRg(?string $rg): self
    {
        $this->rg = $rg;

        return $this;
    }

    public function getTelFixo(): ?string
    {
        return $this->telFixo;
    }

    public function setTelFixo(?string $telFixo): self
    {
        $this->telFixo = $telFixo;

        return $this;
    }

    public function getTelCelular(): ?string
    {
        return $this->telCelular;
    }

    public function setTelCelular(?string $telCelular): self
    {
        $this->telCelular = $telCelular;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getSituacao(): ?string
    {
        return $this->situacao;
    }

    public function setSituacao(?string $situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }
}