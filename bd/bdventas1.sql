CREATE TABLE permisos (
  per_id INT NOT NULL AUTO_INCREMENT,
  per_descripcion VARCHAR(50) NULL,
  per_eliminado CHAR(1) NULL,
  PRIMARY KEY(per_id)
)
TYPE=InnoDB;

CREATE TABLE marcas (
  mar_id INT NOT NULL AUTO_INCREMENT,
  mar_descripcion VARCHAR(50) NULL,
  mar_eliminado CHAR(1) NULL,
  PRIMARY KEY(mar_id)
)
TYPE=InnoDB;

CREATE TABLE unidades (
  uni_id INT NOT NULL AUTO_INCREMENT,
  uni_descripcion VARCHAR(50) NULL,
  uni_factor DECIMAL(10,2) NULL,
  uni_eliminado CHAR(1) NULL,
  PRIMARY KEY(uni_id)
)
TYPE=InnoDB;

CREATE TABLE tipo_usuario (
  tipu_id INT NOT NULL AUTO_INCREMENT,
  tipu_descripcion VARCHAR(50) NULL,
  PRIMARY KEY(tipu_id)
)
TYPE=InnoDB;

CREATE TABLE lineas (
  lin_id INT NOT NULL AUTO_INCREMENT,
  lin_descripcion VARCHAR(50) NULL,
  lin_eliminado CHAR(1) NULL,
  PRIMARY KEY(lin_id)
)
TYPE=InnoDB;

CREATE TABLE clientes (
  cli_id INT NOT NULL AUTO_INCREMENT,
  cli_razonsocial VARCHAR(100) NULL,
  cli_direccion VARCHAR(100) NULL,
  cli_ruc CHAR(11) NULL,
  cli_eliminado CHAR(1) NULL,
  PRIMARY KEY(cli_id)
)
TYPE=InnoDB;

CREATE TABLE areas (
  are_id INT NOT NULL AUTO_INCREMENT,
  are_descripcion VARCHAR(50) NULL,
  are_eliminado CHAR(1) NULL,
  PRIMARY KEY(are_id)
)
TYPE=InnoDB;

CREATE TABLE usuarios (
  usu_id INT NOT NULL AUTO_INCREMENT,
  tipu_id INT NOT NULL,
  usu_nombres VARCHAR(50) NULL,
  usu_apellidos VARCHAR(50) NULL,
  usu_direccion VARCHAR(100) NULL,
  usu_telefono VARCHAR(20) NULL,
  usu_usuario VARCHAR(15) NULL,
  usu_clave VARCHAR(255) NULL,
  usu_eliminado CHAR(1) NULL,
  PRIMARY KEY(usu_id),
  INDEX usuarios_FKIndex1(tipu_id),
  FOREIGN KEY(tipu_id)
    REFERENCES tipo_usuario(tipu_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE ventas (
  ven_id INT NOT NULL AUTO_INCREMENT,
  cli_id INT NOT NULL,
  ven_fecha DATE NULL,
  ven_estado CHAR(1) NULL,
  PRIMARY KEY(ven_id),
  INDEX ventas_FKIndex1(cli_id),
  FOREIGN KEY(cli_id)
    REFERENCES clientes(cli_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE usuarios_permisos (
  per_id INT NOT NULL,
  usu_id INT NOT NULL,
  PRIMARY KEY(per_id, usu_id),
  INDEX permisos_has_usuarios_FKIndex1(per_id),
  INDEX permisos_has_usuarios_FKIndex2(usu_id),
  FOREIGN KEY(per_id)
    REFERENCES permisos(per_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usu_id)
    REFERENCES usuarios(usu_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE productos (
  pro_id INT NOT NULL AUTO_INCREMENT,
  mar_id INT NOT NULL,
  lin_id INT NOT NULL,
  pro_stock INT NULL,
  pro_eliminado CHAR(1) NULL,
  PRIMARY KEY(pro_id),
  INDEX productos_FKIndex1(mar_id),
  INDEX productos_FKIndex2(lin_id),
  FOREIGN KEY(lin_id)
    REFERENCES lineas(lin_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(mar_id)
    REFERENCES marcas(mar_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE ingresos (
  ing_id INT NOT NULL AUTO_INCREMENT,
  pro_id INT NOT NULL,
  ing_cantidad INT NULL,
  ing_fecha DATE NULL,
  PRIMARY KEY(ing_id),
  INDEX ingresos_FKIndex1(pro_id),
  FOREIGN KEY(pro_id)
    REFERENCES productos(pro_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE precios (
  pre_id INT NOT NULL AUTO_INCREMENT,
  uni_id INT NOT NULL,
  pro_id INT NOT NULL,
  pre_precio DECIMAL(10,2) NULL,
  pre_eliminado CHAR(1) NULL,
  PRIMARY KEY(pre_id),
  INDEX precios_FKIndex1(pro_id),
  INDEX precios_FKIndex2(uni_id),
  FOREIGN KEY(pro_id)
    REFERENCES productos(pro_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(uni_id)
    REFERENCES unidades(uni_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE detalle_ventas (
  dve_id INT NOT NULL AUTO_INCREMENT,
  pro_id INT NOT NULL,
  ven_id INT NOT NULL,
  ven_cantidad DECIMAL(10,2) NULL,
  ven_unidades DECIMAL(10,2) NULL,
  ven_precio_cantidad DECIMAL(10,2) NULL,
  ven_totalcantidad DECIMAL(10,2) NULL,
  ven_preciounidades DECIMAL(10,2) NULL,
  ven_preciototal DECIMAL(10,2) NULL,
  PRIMARY KEY(dve_id),
  INDEX detalle_ventas_FKIndex1(ven_id),
  INDEX detalle_ventas_FKIndex2(pro_id),
  FOREIGN KEY(ven_id)
    REFERENCES ventas(ven_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(pro_id)
    REFERENCES productos(pro_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;


