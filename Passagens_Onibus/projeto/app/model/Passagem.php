<?php 
#Nome do arquivo: venda.php
#Objetivo: classe Model para Venda

require_once(__DIR__ . '/Viagens.php');

class Passagem {

    private ?int $id;
    private ?float $valor;
    private ?string $nome;
    private ?string $cpf;
    private $dataVenda;
  
    public function getId(): ?int
    {
        return $this->id;   
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
    
    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(?float $valor): self
    {
        $this->valor = $valor;

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
     * Get the value of cpf
     */
    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }
}
