-- -----------------------------------------------------
-- Schema infoinova
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `infoinova`;
CREATE SCHEMA IF NOT EXISTS `infoinova` ;
USE `infoinova` ;

-- -----------------------------------------------------
-- Table `infoinova`.`modalidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`modalidade` (
  `mod_id` INT NOT NULL AUTO_INCREMENT,
  `mod_codigo` VARCHAR(45) NOT NULL,
  `mod_nome` VARCHAR(45) NOT NULL,
  `mod_descricao` VARCHAR(200) NULL,
  `mod_valMensal` FLOAT NOT NULL,
  `mod_valAnual` FLOAT NOT NULL,
  `mod_edital` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`mod_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`empresa` (
  `emp_id` INT NOT NULL AUTO_INCREMENT,
  `emp_razao_social` VARCHAR(120) NOT NULL,
  `emp_cpf` VARCHAR(14) NULL,
  `emp_cnpj` VARCHAR(18) NULL,
  `emp_telefone` VARCHAR(14) NOT NULL,
  `emp_area_atuacao` VARCHAR(120) NOT NULL,
  `mod_id` INT NULL,
  `emp_nome_fantasia` VARCHAR(120) NOT NULL,
  `emp_residente` TINYINT(1) NULL,
  `emp_municipio` VARCHAR(45) NOT NULL,
  `emp_endereco` VARCHAR(120) NOT NULL,
  `emp_bairro` VARCHAR(120) NOT NULL,
  `emp_estado` VARCHAR(45) NOT NULL,
  `emp_cep` VARCHAR(9) NOT NULL,
  `emp_email` VARCHAR(120) NOT NULL,
  `emp_complemento` VARCHAR(40) NULL,
  `emp_numero` INT NULL,
  PRIMARY KEY (`emp_id`),
  UNIQUE INDEX `emp_cnpj_UNIQUE` (`emp_cnpj` ASC) VISIBLE,
  INDEX `fk_empresa_modalidade1_idx` (`mod_id` ASC) VISIBLE,
  CONSTRAINT `fk_empresa_modalidade1`
    FOREIGN KEY (`mod_id`)
    REFERENCES `infoinova`.`modalidade` (`mod_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`perfil_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`perfil_usuario` (
  `pu_id` INT NOT NULL AUTO_INCREMENT,
  `pu_descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`pu_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`area_interesse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`area_interesse` (
  `ai_id` INT NOT NULL AUTO_INCREMENT,
  `ai_descricao` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`ai_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`usuario` (
  `usu_id` INT NOT NULL AUTO_INCREMENT,
  `pu_id` INT NOT NULL,
  `emp_id` INT NULL,
  `usu_nome` VARCHAR(120) NOT NULL,
  `usu_rg` VARCHAR(12) NOT NULL,
  `usu_cpf` VARCHAR(14) NOT NULL,
  `usu_data_nascimento` DATE NOT NULL,
  `usu_responsavel` VARCHAR(120) NULL,
  `usu_tel_responsavel` VARCHAR(14) NULL,
  `usu_endereco` VARCHAR(120) NOT NULL,
  `usu_cep` VARCHAR(9) NOT NULL,
  `usu_bairro` VARCHAR(120) NOT NULL,
  `usu_municipio` VARCHAR(45) NOT NULL,
  `usu_area_atuacao` VARCHAR(120) NOT NULL,
  `ai_id` INT NULL,
  `usu_telefone` VARCHAR(14) NOT NULL,
  `usu_email` VARCHAR(120) NOT NULL,
  `usu_senha` VARCHAR(60) NULL,
  `usu_socio` TINYINT(1) NULL,
  `usu_primeiro_login` TINYINT(1) NOT NULL,
  `usu_nomedeusuario` VARCHAR(60) NULL,
  `usu_complemento` VARCHAR(45) NULL,
  `usu_estado` VARCHAR(45) NOT NULL,
  `usu_numero` INT NULL,
  PRIMARY KEY (`usu_id`),
  INDEX `fk_pessoa_fisica_empresa1_idx` (`emp_id` ASC) VISIBLE,
  UNIQUE INDEX `pf_cpf_UNIQUE` (`usu_cpf` ASC) VISIBLE,
  UNIQUE INDEX `pf_rg_UNIQUE` (`usu_rg` ASC) VISIBLE,
  INDEX `fk_usuario_perfil_usuario1_idx` (`pu_id` ASC) VISIBLE,
  UNIQUE INDEX `usu_nomedeusuario_UNIQUE` (`usu_nomedeusuario` ASC) VISIBLE,
  INDEX `fk_usuario_area_interesse1_idx` (`ai_id` ASC) VISIBLE,
  CONSTRAINT `fk_usuario_empresa1`
    FOREIGN KEY (`emp_id`)
    REFERENCES `infoinova`.`empresa` (`emp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_perfil_usuario1`
    FOREIGN KEY (`pu_id`)
    REFERENCES `infoinova`.`perfil_usuario` (`pu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_area_interesse1`
    FOREIGN KEY (`ai_id`)
    REFERENCES `infoinova`.`area_interesse` (`ai_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`check_in`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`check_in` (
  `che_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT NOT NULL,
  `che_horario_entrada` DATETIME NULL,
  `che_horario_saida` DATETIME NULL,
  PRIMARY KEY (`che_id`),
  CONSTRAINT `fk_check_in_usuario1`
    FOREIGN KEY (`usu_id`)
    REFERENCES `infoinova`.`usuario` (`usu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`sala`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`sala` (
  `sa_id` INT NOT NULL AUTO_INCREMENT,
  `sa_nome_espaco` VARCHAR(45) NOT NULL,
  `sa_capacidade` INT NOT NULL,
  `sa_valor_periodo` FLOAT NOT NULL,
  `sa_valor_hora` FLOAT NOT NULL,
  `sa_localizacao` VARCHAR(45) NOT NULL,
  `sa_ambiente_climatizado` TINYINT(1) NOT NULL,
  `sa_projetor` TINYINT(1) NOT NULL,
  `sa_caixa_som` TINYINT(1) NOT NULL,
  `sa_cadeiras_apoio` TINYINT(1) NOT NULL,
  `sa_iluminacao` VARCHAR(45) NOT NULL,
  `sa_disponibilidade` TINYINT(1) NOT NULL,
  `sa_frigobar` TINYINT(1) NOT NULL,
  PRIMARY KEY (`sa_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`reserva_sala`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`reserva_sala` (
  `res_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT NOT NULL,
  `sa_id` INT NOT NULL,
  `res_incio` DATETIME NOT NULL,
  `res_fim` DATETIME NOT NULL,
  `res_pagamento` TINYINT(1) NOT NULL,
  `res_observacoes` VARCHAR(120) NULL,
  `res_valor_total` FLOAT NULL,
  INDEX `fk_aluguel_sala_Sala1_idx` (`sa_id` ASC) VISIBLE,
  PRIMARY KEY (`res_id`),
  INDEX `fk_reservar_sala_pessoa_fisica1_idx` (`usu_id` ASC) VISIBLE,
  CONSTRAINT `fk_reserva_sala_Sala1`
    FOREIGN KEY (`sa_id`)
    REFERENCES `infoinova`.`sala` (`sa_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_sala_usuario1`
    FOREIGN KEY (`usu_id`)
    REFERENCES `infoinova`.`usuario` (`usu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`tipo_evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`tipo_evento` (
  `tip_id` INT NOT NULL AUTO_INCREMENT,
  `tip_descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tip_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`evento` (
  `eve_id` INT NOT NULL AUTO_INCREMENT,
  `res_id` INT NULL,
  `tip_id` INT NOT NULL,
  `eve_nome` VARCHAR(45) NOT NULL,
  `eve_valor_entrada` FLOAT NOT NULL,
  `eve_qtd_inscritos` INT NOT NULL,
  `eve_qtd_presentes` INT NOT NULL,
  `eve_ministrante` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`eve_id`),
  INDEX `fk_evento_aluguel_sala1_idx` (`res_id` ASC) VISIBLE,
  INDEX `fk_evento_tipos_evento1_idx` (`tip_id` ASC) VISIBLE,
  CONSTRAINT `fk_evento_reserva_sala1`
    FOREIGN KEY (`res_id`)
    REFERENCES `infoinova`.`reserva_sala` (`res_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evento_tipo_evento1`
    FOREIGN KEY (`tip_id`)
    REFERENCES `infoinova`.`tipo_evento` (`tip_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `infoinova`.`ocorrencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `infoinova`.`ocorrencia` (
  `oc_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT NOT NULL,
  `oc_data` DATETIME NOT NULL,
  `oc_descricao` VARCHAR(120) NOT NULL,
  INDEX `fk_ocorrencias_pessoa_fisica1_idx` (`usu_id` ASC) VISIBLE,
  PRIMARY KEY (`oc_id`),
  CONSTRAINT `fk_ocorrencia_usuario1`
    FOREIGN KEY (`usu_id`)
    REFERENCES `infoinova`.`usuario` (`usu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

GRANT ALL PRIVILEGES ON `infoinova`.* TO 'tutorial';

INSERT INTO `area_interesse` (`ai_descricao`) VALUES ('area 101');
INSERT INTO `area_interesse` (`ai_descricao`) VALUES ('area 202');

USE `infoinova` ;