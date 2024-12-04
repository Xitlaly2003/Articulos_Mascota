--Tabla categoría
CREATE TABLE categoria(
       idcategoria INT PRIMARY KEY AUTO_INCREMENT,
       nombre VARCHAR(50) NOT NULL UNIQUE,
       descripcion VARCHAR(256),
       estado BIT DEFAULT(1)
);

INSERT INTO categoria (nombre, descripcion, estado)
VALUES
('Ropa para Mascotas', 'Vestimenta cómoda y funcional para perros y gatos, ideal para protección contra el clima y estilos divertidos.', 1),
('Alimentos Medicados', 'Alimentos especializados para mascotas con necesidades médicas o dietas específicas.', 1),
('Acuarios y Accesorios', 'Equipos, decoraciones y suministros para peces y otros animales acuáticos.', 1),
('Transporte para Mascotas', 'Jaulas, mochilas y accesorios para transportar a tus mascotas de manera segura.', 1),
('Higiene y Cuidado Personal', 'Productos para el baño, corte de uñas, limpieza dental y cuidado general.', 1),
('Suplementos y Vitaminas', 'Complementos nutricionales para mejorar la salud y bienestar de las mascotas.', 1),
('Entrenamiento y Educación', 'Artículos para adiestramiento como clickers, correas especiales, y guías de educación.', 1),
('Snacks y Premios', 'Bocadillos y golosinas saludables para recompensar y consentir a las mascotas.', 1),
('Cuidado de Cachorros y Gatitos', 'Productos específicos para las necesidades de mascotas jóvenes en sus primeros meses de vida.', 1),
('Piscinas y Diversión Acuática', 'Piscinas y juguetes resistentes al agua para mascotas que aman jugar en el agua.', 1);


SELECT * FROM categoria;

--Tabla artículo
CREATE TABLE articulo(
       idarticulo INT PRIMARY KEY AUTO_INCREMENT,
       idcategoria INT NOT NULL,
       codigo VARCHAR(50),
       nombre VARCHAR(100) not null unique,
       precio_venta DECIMAL(11,2) not null,
       stock INT NOT NULL,
       descripcion VARCHAR(256),
       estado bit DEFAULT(1),
       FOREIGN KEY (idcategoria) REFERENCES categoria(idcategoria)
);

INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion, estado)
VALUES
(1, 'RO001', 'Chamarra para Perros', 450.00, 20, 'Chamarra acolchada para proteger contra el frío.', 1),
(1, 'RO002', 'Capa Impermeable', 350.00, 15, 'Capa ligera resistente al agua.', 1),
(1, 'RO003', 'Suéter Tejido', 250.00, 25, 'Suéter cálido y cómodo para perros pequeños.', 1),

(2, 'AL001', 'Croquetas Renal para Perros', 800.00, 10, 'Alimento para perros con problemas renales.', 1),
(2, 'AL002', 'Comida Hipoalergénica para Gatos', 650.00, 8, 'Fórmula especial para gatos con alergias.', 1),
(2, 'AL003', 'Dietas Gastrointestinales', 900.00, 12, 'Alimento recomendado para mascotas con problemas digestivos.', 1),

(3, 'AC001', 'Acuario de Cristal 40L', 1200.00, 5, 'Acuario compacto para peces pequeños.', 1),
(3, 'AC002', 'Filtro de Agua para Acuarios', 600.00, 10, 'Filtro eficiente para mantener el agua limpia.', 1),
(3, 'AC003', 'Decoración de Coral Artificial', 300.00, 20, 'Elemento decorativo no tóxico para acuarios.', 1),

(4, 'TR001', 'Mochila Porta Mascotas', 750.00, 10, 'Mochila transpirable ideal para gatos y perros pequeños.', 1),
(4, 'TR002', 'Jaula de Transporte Mediana', 900.00, 7, 'Jaula resistente para viajes largos.', 1),
(4, 'TR003', 'Asiento para Autos', 1100.00, 5, 'Asiento acolchonado para transportar mascotas en el coche.', 1),

(5, 'HI001', 'Shampoo Antipulgas', 200.00, 30, 'Shampoo especializado para eliminar pulgas y garrapatas.', 1),
(5, 'HI002', 'Cepillo de Pelo', 150.00, 20, 'Cepillo suave para mascotas de pelo largo.', 1),
(5, 'HI003', 'Cortaúñas para Mascotas', 120.00, 15, 'Herramienta segura para cortar uñas de forma precisa.', 1),

(6, 'SU001', 'Omega 3 para Mascotas', 350.00, 10, 'Suplemento para mejorar el pelaje y salud de las articulaciones.', 1),
(6, 'SU002', 'Vitaminas Multiespecies', 400.00, 12, 'Complejo vitamínico para todas las mascotas.', 1),
(6, 'SU003', 'Calcio para Cachorros', 300.00, 8, 'Suplemento de calcio para el desarrollo de huesos fuertes.', 1),

(7, 'EN001', 'Clicker de Entrenamiento', 100.00, 50, 'Herramienta básica para adiestrar mascotas.', 1),
(7, 'EN002', 'Collar de Entrenamiento', 500.00, 15, 'Collar ajustable para entrenamiento de obediencia.', 1),
(7, 'EN003', 'Juguete de Refuerzo', 200.00, 20, 'Juguete interactivo para refuerzo positivo.', 1),

(8, 'SN001', 'Galletas de Pollo', 180.00, 40, 'Premios saludables hechos con pollo real.', 1),
(8, 'SN002', 'Huesos Masticables', 220.00, 30, 'Huesos para mantener los dientes limpios y fuertes.', 1),
(8, 'SN003', 'Snacks de Pescado', 250.00, 25, 'Snacks ricos en omega-3 para perros y gatos.', 1),

(9, 'CU001', 'Terrario de Vidrio', 1500.00, 3, 'Espacio ideal para reptiles pequeños.', 1),
(9, 'CU002', 'Lámpara de Calor UV', 500.00, 10, 'Lámpara especial para reptiles tropicales.', 1),
(9, 'CU003', 'Comida para Tortugas', 200.00, 15, 'Alimento balanceado para tortugas acuáticas.', 1),

(10, 'PI001', 'Jaula para Aves', 1200.00, 5, 'Jaula espaciosa para aves medianas y grandes.', 1),
(10, 'PI002', 'Percha de Madera', 150.00, 20, 'Percha natural para aves.', 1),
(10, 'PI003', 'Comida para Loros', 400.00, 12, 'Alimento enriquecido para loros y aves grandes.', 1);

--Tabla persona
create table persona(
       idpersona INT PRIMARY KEY AUTO_INCREMENT,
       tipo_persona VARCHAR(20) NOT NULL,
       nombre VARCHAR(100) NOT NULL,
       tipo_documento VARCHAR(20),
       num_documento VARCHAR(20),
       direccion VARCHAR(70),
       telefono VARCHAR(20),
       email VARCHAR(50)
);

--Tabla rol
create table rol(
       idrol INT PRIMARY KEY AUTO_INCREMENT,
       nombre VARCHAR(30) NOT NULL,
       descripcion VARCHAR(100),
       estado BIT DEFAULT(1)
);

INSERT INTO rol (nombre, descripcion)
VALUES('ADMIN', 'Usuario de tipo administrador con permisos para modificar cualquier cosa de la página.'),
('CLIENTE', 'Usuario de tipo cliente con los permisos básicos para poder navegar por la página');

--Tabla usuario
create table usuario(
       idusuario INT PRIMARY KEY AUTO_INCREMENT,
       idrol INT NOT NULL,
       nombre VARCHAR(100) NOT NULL,
       tipo_documento VARCHAR(20),
       num_documento VARCHAR(20),
       direccion VARCHAR(70),
       telefono VARCHAR(20),
       email VARCHAR(50) NOT NULL,
       password VARCHAR(255) NOT NULL,
       estado BIT DEFAULT(1),
       FOREIGN KEY (idrol) REFERENCES rol (idrol)
);

--Tabla ingreso
create table ingreso(
       idingreso INT PRIMARY KEY AUTO_INCREMENT,
       idproveedor INT NOT NULL,
       idusuario INT NOT NULL,
       tipo_comprobante VARCHAR(20) NOT NULL,
       serie_comprobante VARCHAR(7),
       num_comprobante VARCHAR(10) NOT NULL,
       fecha DATETIME NOT NULL,
       impuesto DECIMAL(4,2) NOT NULL,
       total DECIMAL(11,2) NOT NULL,
       estado VARCHAR(20) NOT NULL,
       FOREIGN KEY (idproveedor) REFERENCES persona (idpersona),
       FOREIGN KEY (idusuario) REFERENCES usuario (idusuario)
);

--Tabla detalle_ingreso
create table detalle_ingreso(
       iddetalle_ingreso INT PRIMARY KEY AUTO_INCREMENT,
       idingreso INT NOT NULL,
       idarticulo INT NOT NULL,
       cantidad INT NOT NULL,
       precio DECIMAL(11,2) NOT NULL,
       FOREIGN KEY (idingreso) REFERENCES ingreso (idingreso) ON DELETE CASCADE,
       FOREIGN KEY (idarticulo) REFERENCES articulo (idarticulo)
);

--Tabla venta
create table venta(
       idventa INT PRIMARY KEY AUTO_INCREMENT,
       idcliente INT NOT NULL,
       idusuario INT NOT NULL,
       tipo_comprobante VARCHAR(20) NOT NULL,
       serie_comprobante VARCHAR(7),
       num_comprobante VARCHAR(10) NOT NULL,
       fecha_hora DATETIME NOT NULL,
       impuesto DECIMAL(4,2) NOT NULL,
       total DECIMAL(11,2) NOT NULL,
       estado VARCHAR(20) NOT NULL,
       FOREIGN KEY (idcliente) REFERENCES persona (idpersona),
       FOREIGN KEY (idusuario) REFERENCES usuario (idusuario)
);

--Tabla detalle_venta
create table detalle_venta(
       iddetalle_venta INT PRIMARY KEY AUTO_INCREMENT,
       idventa INT NOT NULL,
       idarticulo INT NOT NULL,
       cantidad INT NOT NULL,
       precio DECIMAL(11,2) NOT NULL,
       descuento DECIMAL(11,2) NOT NULL,
       FOREIGN KEY (idventa) REFERENCES venta (idventa) ON DELETE CASCADE,
       FOREIGN KEY (idarticulo) REFERENCES articulo (idarticulo)
);

DELIMITER //

CREATE TRIGGER person_insert
AFTER INSERT ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO persona (idpersona, tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email)
    VALUES (NEW.idusuario, 'Cliente', NEW.nombre, NEW.tipo_documento, NEW.num_documento, NEW.direccion, NEW.telefono, NEW.email);
END;
//

DELIMITER ;
