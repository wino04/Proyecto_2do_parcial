
CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(150) NOT NULL,
    estado_pais VARCHAR(100)NOT NULL,
    telefono VARCHAR(10),
    genero VARCHAR(9) NOT NULL
    
);

CREATE TABLE libro (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    genero VARCHAR(50),
    anio_publicacion INT,
    idioma VARCHAR(50),
    descripcion TEXT
);


CREATE TABLE librosusuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    libro_id INT,
    foto_libro BLOB, 
    motivo_cambio TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (libro_id) REFERENCES libro(id)
);