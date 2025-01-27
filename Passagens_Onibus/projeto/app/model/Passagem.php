<?php 
#Nome do arquivo: venda.php
#Objetivo: classe Model para Venda

require_once(__DIR__ . '/Viagens.php');
require_once(__DIR__ . '/Usuario.php');

class Passagem {

    private ?int $id;
    private ?string $nome;
    private ?string $cpf;
    private $dataVenda;

    private ?Usuario $usuario;
    private ?Viagens $viagem;

  
    public function getId(): ?int
    {
        return $this->id;   
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
    
    public function getQuantidade(): ?int
    {
        return $this->id;   
    }

    public function setQuantidade(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDataVenda(): ?string
    {
        return $this->dataVenda;
    }

    public function setDataVenda(?string $dataVenda): self
    {
        $this->dataVenda = $dataVenda;

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

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getViagem(): ?Viagens
    {
        return $this->viagem;
    }

    public function setViagem(?Viagens $viagem): self
    {
        $this->viagem = $viagem;

        return $this;
    }
}
