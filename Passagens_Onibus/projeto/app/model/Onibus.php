<?php 
# Nome do arquivo: Onibus.php
# Objetivo: classe Model para Onibus

class Onibus {

    private ?int $id;
    private ?string $modelo;
    private ?string $marca;
    private ?int $totalAssentos;
    private ?int $usuariosId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(?string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(?string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getTotalAssentos(): ?int
    {
        return $this->totalAssentos;
    }

    public function setTotalAssentos(?int $totalAssentos): self
    {
        $this->totalAssentos = $totalAssentos;

        return $this;
    }

    public function getUsuariosId(): ?int
    {
        return $this->usuariosId;
    }

    public function setUsuariosId(?int $usuariosId): self
    {
        $this->usuariosId = $usuariosId;

        return $this;
    }

    
}
