SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `lineas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lineas` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `lineas` (
  `lin_id` INT NOT NULL ,
  `lin_descripcion` VARCHAR(50) NULL ,
  `lin_eliminado` CHAR(1) NULL ,
  PRIMARY KEY (`lin_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `marcas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `marcas` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `marcas` (
  `mar_id` INT NOT NULL ,
  `mar_descripcion` VARCHAR(50) NULL ,
  `mar_eliminado` CHAR(1) NULL ,
  PRIMARY KEY (`mar_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productos` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `productos` (
  `pro_id` INT NOT NULL ,
  `pro_descripcion` VARCHAR(150) NULL ,
  `pro_stock` VARCHAR(45) NULL ,
  `lin_id` INT NOT NULL ,
  `mar_id` INT NOT NULL ,
  PRIMARY KEY (`pro_id`) ,
  CONSTRAINT `fk_productos_lineas`
    FOREIGN KEY (`lin_id` )
    REFERENCES `lineas` (`lin_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_marcas1`
    FOREIGN KEY (`mar_id` )
    REFERENCES `marcas` (`mar_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_productos_lineas` ON `productos` (`lin_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_productos_marcas1` ON `productos` (`mar_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `unidades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unidades` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `unidades` (
  `uni_id` INT NOT NULL ,
  `uni_descripcion` VARCHAR(50) NULL ,
  `uni_eliminado` CHAR(1) NULL ,
  PRIMARY KEY (`uni_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `precios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `precios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `precios` (
  `pre_id` INT NOT NULL ,
  `pre_cantidad` DECIMAL(10,2) NULL ,
  `pre_precio` DECIMAL(10,2) NULL ,
  `pro_id` INT NOT NULL ,
  `uni_id` INT NOT NULL ,
  PRIMARY KEY (`pre_id`) ,
  CONSTRAINT `fk_precios_productos1`
    FOREIGN KEY (`pro_id` )
    REFERENCES `productos` (`pro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_precios_unidades1`
    FOREIGN KEY (`uni_id` )
    REFERENCES `unidades` (`uni_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_precios_productos1` ON `precios` (`pro_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_precios_unidades1` ON `precios` (`uni_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `cajas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cajas` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `cajas` (
  `caj_id` INT NOT NULL ,
  `caj_descripcion` VARCHAR(45) NULL ,
  `caj_eliminado` CHAR(1) NULL ,
  PRIMARY KEY (`caj_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ventas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ventas` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `ventas` (
  `ven_id` INT NOT NULL ,
  `ven_fecha` DATE NULL ,
  `ven_anulado` CHAR(1) NULL ,
  `caj_id` INT NOT NULL ,
  PRIMARY KEY (`ven_id`) ,
  CONSTRAINT `fk_ventas_cajas1`
    FOREIGN KEY (`caj_id` )
    REFERENCES `cajas` (`caj_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_ventas_cajas1` ON `ventas` (`caj_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detalle_ventas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detalle_ventas` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `detalle_ventas` (
  `detv_id` INT NOT NULL ,
  `detv_cantidad` DECIMAL(10,2) NULL ,
  `detv_precio` DECIMAL(10,2) NULL ,
  `detv_importe` DECIMAL(10,2) NULL ,
  `ven_id` INT NOT NULL ,
  `pro_id` INT NOT NULL ,
  PRIMARY KEY (`detv_id`) ,
  CONSTRAINT `fk_detalle_ventas_ventas1`
    FOREIGN KEY (`ven_id` )
    REFERENCES `ventas` (`ven_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_ventas_productos1`
    FOREIGN KEY (`pro_id` )
    REFERENCES `productos` (`pro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_detalle_ventas_ventas1` ON `detalle_ventas` (`ven_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_detalle_ventas_productos1` ON `detalle_ventas` (`pro_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tipo_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipo_usuario` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `tipo_usuario` (
  `tipu_id` INT NOT NULL ,
  `tipu_descripcion` VARCHAR(45) NULL ,
  PRIMARY KEY (`tipu_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuarios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `usuarios` (
  `usu_id` INT NOT NULL ,
  `usu_nombres` VARCHAR(45) NULL ,
  `usu_apellidos` VARCHAR(45) NULL ,
  `usu_direccion` VARCHAR(45) NULL ,
  `usu_telefono` VARCHAR(45) NULL ,
  `usu_usuario` VARCHAR(15) NULL ,
  `usu_clave` VARCHAR(255) NULL ,
  `usu_eliminado` CHAR(1) NULL ,
  `tipu_id` INT NOT NULL ,
  PRIMARY KEY (`usu_id`) ,
  CONSTRAINT `fk_usuarios_tipo_usuario1`
    FOREIGN KEY (`tipu_id` )
    REFERENCES `tipo_usuario` (`tipu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_usuarios_tipo_usuario1` ON `usuarios` (`tipu_id` ASC) ;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
