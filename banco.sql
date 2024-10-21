-- -----------------------------------------------------
-- Table `usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('MANTENEDOR', 'MOTORISTA', 'CLIENTE') NOT NULL,
  `nome` VARCHAR(70) NOT NULL,
  `cpf` VARCHAR(20) NOT NULL,
  `email` VARCHAR(70) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `rg` VARCHAR(45) NOT NULL,
  `tel_fixo` VARCHAR(20) NULL,
  `tel_celular` VARCHAR(20) NOT NULL,
  `situacao` ENUM('ATIVO', 'INATIVO') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

ALTER TABLE usuarios ADD CONSTRAINT uk_usuario UNIQUE (email);



-- -----------------------------------------------------
-- Table `onibus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onibus` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `modelo` VARCHAR(30) NOT NULL,
  `marca` VARCHAR(30) NOT NULL,
  `total_assentos` INT NOT NULL,
  `usuarios_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_onibus_usuarios1_idx` (`usuarios_id` ASC) VISIBLE,
  CONSTRAINT `fk_onibus_usuarios1`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `viagens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `viagens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `onibus_id` INT NOT NULL,
  `data_horario` DATETIME NOT NULL,
  `cidade_origem` VARCHAR(50) NOT NULL,
  `cidade_destino` VARCHAR(45) NOT NULL,
  `preco` FLOAT NOT NULL,
  `total_passagens` INT NOT NULL,
  `situacao` ENUM('PROGRAMADA', 'FINALIZADA') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_viagens_onibus1_idx` (`onibus_id` ASC) VISIBLE,
  CONSTRAINT `fk_viagens_onibus1`
    FOREIGN KEY (`onibus_id`)
    REFERENCES `onibus` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `passagens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `passagens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `viagens_id` INT NOT NULL,
  `usuarios_id` INT NOT NULL,
  `forma_pagamento` ENUM('PIX', 'DINHEIRO', 'CARTAO') NOT NULL,
  `comentario` TEXT NULL,
  `avaliacao` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_compra_usuarios1_idx` (`usuarios_id` ASC) VISIBLE,
  INDEX `fk_passagens_viagens1_idx` (`viagens_id` ASC) VISIBLE,
  CONSTRAINT `fk_compra_usuarios1`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_passagens_viagens1`
    FOREIGN KEY (`viagens_id`)
    REFERENCES `viagens` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
