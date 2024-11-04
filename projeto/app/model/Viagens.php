<?php 
# Nome do arquivo: Viagens.php
# Objetivo: classe Model para Viagens

class Viagens {

    private ?int $id;
    private ?int $onibus_id;
    private ?string $data_horario;
    private ?string $cidade_origem;
    private ?string $cidade_destino;
    private ?float $preco;
    private ?int $total_passagens;
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

    public function getOnibusId(): ?int
    {
        return $this->onibus_id;
    }

    public function setOnibusId(?int $onibus_id): self
    {
        $this->onibus_id = $onibus_id;
        return $this;
    }

    public function getDataHorario(): ?string
    {
        return $this->data_horario;
    }

    public function setDataHorario(?string $data_horario): self
    {
        $this->data_horario = $data_horario;
        return $this;
    }

    public function getCidadeOrigem(): ?string
    {
        return $this->cidade_origem;
    }

    public function setCidadeOrigem(?string $cidade_origem): self
    {
        $this->cidade_origem = $cidade_origem;
        return $this;
    }

    public function getCidadeDestino(): ?string
    {
        return $this->cidade_destino;
    }

    public function setCidadeDestino(?string $cidade_destino): self
    {
        $this->cidade_destino = $cidade_destino;
        return $this;
    }

    public function getPreco(): ?float
    {
        return $this->preco;
    }

    public function setPreco(?float $preco): self
    {
        $this->preco = $preco;
        return $this;
    }

    public function getTotalPassagens(): ?int
    {
        return $this->total_passagens;
    }

    public function setTotalPassagens(?int $total_passagens): self
    {
        $this->total_passagens = $total_passagens;
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
