CREATE DATABASE sistema_de_turnos;

USE sistema_de_turnos;

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni INT UNIQUE,
    nombre VARCHAR(255),
    apellido VARCHAR(255),
    email VARCHAR(255),
    contraseña VARCHAR(255),
    estado VARCHAR(255),
    esSuperUsuario BOOLEAN,
    esStaff BOOLEAN
);

CREATE TABLE medico (
    id INT AUTO_INCREMENT PRIMARY KEY,
	dni INT,
    matricula VARCHAR(255),
    especialidad VARCHAR(255),
    estado VARCHAR(255),
    FOREIGN KEY (dni) REFERENCES usuario(dni)
);

CREATE TABLE administrativo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni INT,
    FOREIGN KEY (dni) REFERENCES usuario(dni)
);

CREATE TABLE paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni INT,
    FOREIGN KEY (dni) REFERENCES usuario(dni)
);

CREATE TABLE turno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni_paciente INT,
    dni_medico INT,
    fecha_atencion DATE,
    fecha_creacion DATE,
    horario TIME,
    especialidad VARCHAR(255),
    estado VARCHAR(255),
    FOREIGN KEY (dni_medico) REFERENCES medico(dni),
    FOREIGN KEY (dni_paciente) REFERENCES paciente(dni)
)

CREATE TABLE turnos_solicitados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni_paciente INT,
    fecha_atencion DATE,
    fecha_creacion DATE,
    horario TIME,
    especialidad VARCHAR(255),
    estado VARCHAR(255),
    FOREIGN KEY (dni_paciente) REFERENCES paciente(dni))


INSERT INTO usuario (dni, nombre, apellido, email, contraseña, estado, esSuperUsuario, esStaff) VALUES (99999999, "ADMIN", "ADMIN", "admin@admin.com", "$2a$12$7MIHNQlTUnLAT/xXAWiPdOHRlFqWcLIjLvOqcGRNR5QR1OLlTCfV.", "ALTA", 1, 1);

INSERT INTO administrativo (dni) VALUES (99999999);